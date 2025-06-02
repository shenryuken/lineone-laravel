/**
 * QR Code Scanner Functionality
 * This script handles the QR code scanning functionality for the e-wallet app
 */

class QrScanner {
  constructor(videoElement, onScanSuccess, onScanError) {
    this.videoElement = videoElement
    this.onScanSuccess = onScanSuccess
    this.onScanError = onScanError || this.defaultErrorHandler
    this.scanner = null
    this.isScanning = false
  }

  async start() {
    try {
      // Check if QR Scanner library is loaded
      if (typeof Html5QrcodeScanner === "undefined") {
        console.error("Html5QrcodeScanner library not loaded")
        this.onScanError("QR scanner library not loaded")
        return
      }

      // Request camera permission
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
      this.videoElement.srcObject = stream
      this.videoElement.play()

      // Start scanning
      this.scanner = new Html5QrcodeScanner(
        "qr-video",
        { fps: 10, qrbox: { width: 250, height: 250 } },
        /* verbose= */ false,
      )

      this.scanner.render(this.onScanSuccess, this.onScanError)
      this.isScanning = true

      return true
    } catch (error) {
      console.error("Error starting QR scanner:", error)
      this.onScanError(error.message || "Failed to access camera")
      return false
    }
  }

  stop() {
    if (this.scanner) {
      this.scanner.clear()
    }
    if (this.videoElement && this.videoElement.srcObject) {
      const tracks = this.videoElement.srcObject.getTracks()
      tracks.forEach((track) => track.stop())
      this.videoElement.srcObject = null
    }
    this.isScanning = false
  }

  processFrames() {
    if (!this.isScanning) return

    // This would be replaced with actual QR code detection logic
    // For demonstration purposes, we're simulating a scan after 3 seconds
    setTimeout(() => {
      if (this.isScanning) {
        // Simulate a successful scan
        const mockQrData = JSON.stringify({
          user_id: 123,
          name: "John Doe",
          phone: "+60123456789",
        })

        this.onScanSuccess(mockQrData)
      }
    }, 3000)
  }

  defaultErrorHandler(error) {
    console.error("QR Scanner error:", error)
    alert("Failed to scan QR code: " + error)
  }
}

// Usage example:
// const scanner = new QrScanner(
//     document.getElementById('qr-video'),
//     (result) => {
//         console.log('QR code detected:', result);
//         // Process the scanned QR code
//     }
// );
// scanner.start();
