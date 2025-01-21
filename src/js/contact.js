const contactSubmitButton = document.querySelector('.subbut');
const contactForm = document.querySelector('#contact-form');
const errbox = document.querySelector('.errbox');

const resetForm = (fields) => {
    for(let field of Object.values(fields)){
        field.value = '';
    }
}

const validate = (fields) => {
    const errs = [];
    errbox.classList.remove('render');
    errbox.innerHTML = null;
    const emailRegExp = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/gi;

    (fields.firstName.value.trim().length < 2) && errs.push('Please enter a valid first name.');
    (fields.lastName.value.trim().length < 2) && errs.push('Please enter a valid last name.');
    (!emailRegExp.test(fields.email.value.trim())) && errs.push('Please enter a valid email address.');
    (fields.subject.value.trim().length < 1) && errs.push('Please enter a subject.');
    (fields.messageBody.value.trim().length < 10) && errs.push('Please include an adequate message body.');


    if(errs.length){
        errbox.classList.add('render');
        for(let err of errs){
            errbox.insertAdjacentHTML('beforeend', `<li>${err}</li>`);
        }
    }

    return !!!errs.length;
}

const submitForm = async (evt) => {
    evt.preventDefault();

    const fields = {
        firstName: document.querySelector('#first-name'),
        lastName: document.querySelector('#last-name'),
        email: document.querySelector('#email'),
        subject: document.querySelector('#subject'),
        messageBody: document.querySelector('#message-body')
    }

    if(!validate(fields)) return;

    try{

        const fd = new FormData();
        fd.append('full_name', `${fields.firstName.value.trim()} ${fields.lastName.value.trim()}`);
        fd.append('email', fields.email.value.trim());
        fd.append('subject', fields.subject.value.trim());
        fd.append('message_contents', fields.messageBody.value.trim());

        const response = await fetch('/process-contact-form', {
            mode: 'no-cors',
            method: 'POST',
            body: fd
        });

        if(!response.ok) throw new Error('An error has occurred.');

        alert('Your inquiry has successully been submitted!');

        resetForm(fields);

    }catch(err){
        console.error(err);
        errbox.classList.add('render');
        errbox.insertAdjacentHTML('beforeend', '<li>An error has occurred.</li>');
    }
}

contactForm.addEventListener('submit', submitForm);
contactSubmitButton.addEventListener('click', submitForm);