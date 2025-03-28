<x-app-layout title="Form Layout v3" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
          <h2
            class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl"
          >
            Form Layout 3
          </h2>
          <div class="hidden h-full py-1 sm:flex">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
          </div>
          <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
            <li class="flex items-center space-x-2">
              <a
                class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                href="#"
                >Forms</a
              >
              <svg
                x-ignore
                xmlns="http://www.w3.org/2000/svg"
                class="size-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7"
                />
              </svg>
            </li>
            <li>Form Layout 3</li>
          </ul>
        </div>

        <div class="grid place-items-center">
          <div
            class="card mt-20 w-full max-w-xl p-4 sm:p-5"
            x-data="pages.initCreditCard"
          >
            <div
              class="relative mx-auto -mt-20 h-40 w-72 rounded-lg text-white shadow-xl transition-transform hover:scale-110 lg:h-48 lg:w-80"
            >
              <div class="h-full w-full rounded-lg" :class="creditCardUI"></div>
              <div
                class="absolute top-0 flex h-full w-full flex-col justify-between p-4 sm:p-5"
              >
                <div class="flex justify-between">
                  <div>
                    <p class="text-xs-plus font-light">Name</p>
                    <p
                      class="font-medium uppercase tracking-wide"
                      x-text="nameOnCard"
                    ></p>
                  </div>
                  <template x-if="cardLogoSrc">
                    <img
                      src="null"
                      :src="cardLogoSrc"
                      class="w-12 rounded-lg"
                      alt="creditcard"
                    />
                  </template>
                </div>
                <div class="pt-4">
                  <p class="text-xs-plus font-light">Card Number</p>
                  <p class="font-medium tracking-wide" x-text="cardNumber"></p>
                </div>
              </div>
            </div>
            <div class="flex items-center justify-between py-4">
              <p
                class="text-xl font-semibold text-primary dark:text-accent-light"
                x-text="cardText"
              ></p>
              <div
                class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light"
              >
                Primary
              </div>
            </div>
            <div class="space-y-4">
              <label class="block">
                <span>Card number</span>
                <input
                  class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring-3 dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                  placeholder="**** **** **** ****"
                  type="text"
                  x-model.debounce="cardNumber"
                  x-input-mask="creditCardInput"
                />
              </label>
              <label class="block">
                <span>Name on card</span>
                <input
                  class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring-3 dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                  placeholder="John Doe"
                  type="text"
                  x-model.debounce="nameOnCard"
                />
              </label>
              <div class="grid grid-cols-2 gap-4">
                <label class="block">
                  <span>Expiration date</span>
                  <input
                    class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring-3 dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                    placeholder="mm/yy"
                    type="text"
                    x-input-mask="{ date: true, datePattern: ['m', 'y'] }"
                  />
                </label>
                <label class="block">
                  <span>CVV</span>
                  <input
                    class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring-3 dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                    placeholder="***"
                    type="password"
                    x-input-mask="{ numeral: true }"
                    maxlength="3"
                  />
                </label>
              </div>
              <div class="flex justify-center space-x-2 pt-4">
                <button
                  class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
                >
                  Cancel
                </button>
                <button
                  class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                >
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>
</x-app-layout>
