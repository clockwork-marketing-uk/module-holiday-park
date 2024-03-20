
function showFormFeedback(validation) {
   const formFeedback = document.querySelector('#form-feedback')

   formFeedback.textContent = validation.message
   let index = 0
   validation.fields.forEach(field => {
       formFeedback.textContent += field
       if (validation.fields.length > 1 && index !== validation.fields.length - 1) {
           formFeedback.textContent += ", "
       }
       index ++
   });
}

export { showFormFeedback }