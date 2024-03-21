
const loadingSpinner = document.querySelector('#loading-spinner-booking-summary')
const extrasSummary = document.querySelector('#extras-summary-container')
   
function showExtrasSummaryLoading() {
    loadingSpinner.classList.remove('hidden')
    extrasSummary.classList.add('hidden')
}

function hideExtrasSummaryLoading() {
    loadingSpinner.classList.add('hidden')
}

export { showExtrasSummaryLoading, hideExtrasSummaryLoading }