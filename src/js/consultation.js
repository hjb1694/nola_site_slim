const phoneInput = document.querySelector('#phone');
const consultForm = document.querySelector('#consult-form');
const errbox = document.querySelector('.errbox');

const phoneMaskOptions = {
    mask: '(000) 000-0000'
}

IMask(phoneInput, phoneMaskOptions);


const resetForm = (fields) => {
    for(let field in fields){
        if(field !== 'interests'){
            fields[field].value = '';
        }
    }

    fields['interests'].forEach(i => {
        i.checked = false;
    });
}


const onSelection = function (target){
   
    console.log('called');
    if(target.value){
        const label = document.querySelector(`[data-field=${target.getAttribute('data-field')}] + label`);
        label.style.setProperty('transform', 'translateY(-2.8rem)');
        label.style.setProperty('font-size', '1.2rem');
    }else{
        label.style.setProperty('transform', 'translateY(0)');
        label.style.setProperty('font-size', '2.2rem');
    }
}

const getInterestValues = (interestFields) => {

    let values = [];

    interestFields.forEach(cb => {
        if(cb.checked){
            values.push(cb.value);
        }
    });

    return values;

}

const validate = (fields) => {
    const errs = [];
    errbox.classList.remove('render');
    errbox.innerHTML = null;
    const emailRegExp = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/gi;
    const phoneRegExp = /^\([0-9]{3}\)\s[0-9]{3}\-[0-9]{4}$/g;

    (fields.fullName.value.trim().length < 2) && errs.push('Please enter a valid full name.');
    (!emailRegExp.test(fields.email.value.trim())) && errs.push('Please enter a valid email.');
    (!phoneRegExp.test(fields.phone.value.trim())) && errs.push('Please enter a valid phone number.');
    (!fields.preferContactMethod.value) && errs.push('Please select your prefered method of contact.');
    (!fields.bestTimeToContact.value) && errs.push('Please select a best time to contact.');
    (!getInterestValues(fields.interests).length) && errs.push('Please select at least one topic of interest.');

    if(errs.length){
        for(let err of errs){
            errbox.insertAdjacentHTML('beforeend', `<li>${err}</li>`);
        }
        errbox.classList.add('render');
    }

    return !!!errs.length;
}

const submit = async evt => {

    evt.preventDefault();

    const fields = {
        fullName: document.querySelector('#full-name'),
        email: document.querySelector('#email'),
        phone: document.querySelector('#phone'),
        preferContactMethod: document.querySelector('#prefer-contact'),
        bestTimeToContact: document.querySelector('#best-time-contact'),
        interests: document.getElementsByName('interest')
    }

    if(!validate(fields)) return;

    try{

        const fd = new FormData();
        fd.append('full_name', fields.fullName.value.trim());
        fd.append('email', fields.email.value.trim());
        fd.append('phone', fields.phone.value.trim());
        fd.append('prefer_contact_method', fields.preferContactMethod.value);
        fd.append('best_time_contact', fields.bestTimeToContact.value);
        fd.append('interests', getInterestValues(fields.interests).join(', '));

        const response = await fetch('/process-consultation-form', {
            mode: 'no-cors',
            method: 'POST',
            body: fd
        });

        if(!response.ok) throw new Error("Error");

        alert("Form has been successfully submitted!");

        resetForm(fields);

    }catch(err){
        console.error(err);
        errbox.insertAdjacentHTML('beforeend', `<li>An error has occurred.</li>`);
    }

}

consultForm.addEventListener('submit', submit);