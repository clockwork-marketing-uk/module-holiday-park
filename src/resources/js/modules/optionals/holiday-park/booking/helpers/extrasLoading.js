
const loadingSpinner = document.querySelector('#loading-spinner-extras')
   
function showExtrasLoading() {
    loadingSpinner.classList.remove('hidden')
}

function hideExtrasLoading() {
    loadingSpinner.classList.add('hidden')
}

export { showExtrasLoading, hideExtrasLoading }