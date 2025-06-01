/**
 * E-Wallet Payment SDK
 * Allows merchants to integrate e-wallet payments into their websites
 */

class EWalletSDK {
  constructor(apiKey, options = {}) {
    this.apiKey = apiKey
    this.baseUrl = options.baseUrl || "https://redicash.ai"
    this.mode = options.mode || "popup" // 'popup', 'redirect', 'embed'
    this.onSuccess = options.onSuccess || (() => {})
    this.onError = options.onError || (() => {})
    this.onCancel = options.onCancel || (() => {})
  }

  /**
   * Initialize payment
   */
  async createPayment(paymentData) {
    try {
      const response = await fetch(`${this.baseUrl}/api/widget/payments/initialize`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-API-Key": this.apiKey,
          "X-Signature": this.generateSignature(paymentData),
          "X-Timestamp": Math.floor(Date.now() / 1000).toString(),
        },
        body: JSON.stringify(paymentData),
      })

      const result = await response.json()

      if (result.success) {
        return this.handlePaymentCreated(result.data)
      } else {
        throw new Error(result.error || "Payment creation failed")
      }
    } catch (error) {
      this.onError(error.message)
      throw error
    }
  }

  /**
   * Handle payment creation success
   */
  handlePaymentCreated(paymentData) {
    switch (this.mode) {
      case "popup":
        return this.openPaymentPopup(paymentData.widget_url)
      case "redirect":
        return this.redirectToPayment(paymentData.checkout_url)
      case "embed":
        return this.embedPaymentWidget(paymentData.widget_url)
      default:
        throw new Error("Invalid payment mode")
    }
  }

  /**
   * Open payment in popup
   */
  openPaymentPopup(widgetUrl) {
    const popup = window.open(widgetUrl, "ewallet-payment", "width=500,height=700,scrollbars=yes,resizable=yes")

    // Monitor popup
    const checkClosed = setInterval(() => {
      if (popup.closed) {
        clearInterval(checkClosed)
        this.onCancel("Payment popup was closed")
      }
    }, 1000)

    // Listen for messages from popup
    window.addEventListener("message", (event) => {
      if (event.origin !== "https://redicash.ai") return

      if (event.data.type === "PAYMENT_SUCCESS") {
        clearInterval(checkClosed)
        popup.close()
        this.onSuccess(event.data.payment)
      } else if (event.data.type === "PAYMENT_ERROR") {
        clearInterval(checkClosed)
        popup.close()
        this.onError(event.data.error)
      }
    })

    return popup
  }

  /**
   * Redirect to payment page
   */
  redirectToPayment(checkoutUrl) {
    window.location.href = checkoutUrl
  }

  /**
   * Embed payment widget in iframe
   */
  embedPaymentWidget(widgetUrl, containerId = "ewallet-widget") {
    const container = document.getElementById(containerId)
    if (!container) {
      throw new Error(`Container element with ID '${containerId}' not found`)
    }

    const iframe = document.createElement("iframe")
    iframe.src = widgetUrl
    iframe.style.width = "100%"
    iframe.style.height = "600px"
    iframe.style.border = "none"
    iframe.style.borderRadius = "8px"

    container.innerHTML = ""
    container.appendChild(iframe)

    // Listen for messages from iframe
    window.addEventListener("message", (event) => {
      if (event.origin !== "https://redicash.ai") return

      if (event.data.type === "PAYMENT_SUCCESS") {
        this.onSuccess(event.data.payment)
      } else if (event.data.type === "PAYMENT_ERROR") {
        this.onError(event.data.error)
      }
    })

    return iframe
  }

  /**
   * Check payment status
   */
  async checkPaymentStatus(paymentId) {
    try {
      const response = await fetch(`${this.baseUrl}/api/widget/payments/${paymentId}/status`, {
        headers: {
          "X-API-Key": this.apiKey,
        },
      })

      const result = await response.json()
      return result.success ? result.data : null
    } catch (error) {
      console.error("Failed to check payment status:", error)
      return null
    }
  }

  /**
   * Generate signature for API requests
   */
  generateSignature(data) {
    // This is a simplified signature - in production, use proper HMAC
    const timestamp = Math.floor(Date.now() / 1000).toString()
    const payload = JSON.stringify(data)
    return btoa(timestamp + payload + this.apiKey)
  }
}

// Make it available globally
window.EWalletSDK = EWalletSDK

// Export for module systems
if (typeof module !== "undefined" && module.exports) {
  module.exports = EWalletSDK
}
