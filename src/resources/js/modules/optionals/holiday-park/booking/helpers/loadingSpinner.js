
const loadingSpinner = document.querySelector('#loading-spinner')
   
function showLoadingSpinner() {
    loadingSpinner.classList.remove('hidden')
}

function hideLoadingSpinner() {
    loadingSpinner.classList.add('hidden')
}

export { showLoadingSpinner, hideLoadingSpinner }