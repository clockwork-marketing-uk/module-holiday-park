function updateBookingStepper(bookingStepper, currentState) {
    const bookingSteppers = bookingStepper.querySelectorAll('.stepper')

    bookingSteppers.forEach(stepper => {
        stepper.querySelector('.checkmark').classList.add('hidden')
        stepper.classList.remove('text-primary')
        stepper.querySelector('.progress-number').classList.remove('hidden')
    });

    for (let i = 0; i <= currentState; i++) {
        if (bookingSteppers[i]) {
            if (i !== currentState) {
                bookingSteppers[i].querySelector('.checkmark').classList.remove('hidden')
                bookingSteppers[i].querySelector('.progress-number').classList.add('hidden')
            }
            bookingSteppers[i].classList.add('text-primary')
            
        }
    }
}

export { updateBookingStepper }