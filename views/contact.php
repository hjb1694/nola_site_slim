<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MJM Consulting | Nola Swartz | Contact Me</title>
    <meta property="og:site_name" content="MJM Consulting Tennessee" />
    <meta property="og:title" content="MJM Consulting Tennessee | Contact Me" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.mjmconsultingtn.com/contact" />
    <meta property="og:image" content="https://www.mjmconsultingtn.com/public/assets/img/nola_portrait.webp" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/public/assets/style/main.css" />
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__one">
                <a href="/" class="header__logo">
                    <img class="logo" src="/public/assets/img/mjm_logo_black.png" alt="logo" />
                    <h1>MJM Consulting & Bookkeeping</h1>
                </a>
            </div>
            <div class="header__two">
                <nav class="header__nav">
                    <a href="/" class="hide-mobile">Home</a>
                    <a href="/contact">Contact</a>
                    <a href="/request-consultation" class="link-btn">Request Consultation</a>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="main-view">
            <section class="contact-section">
                <aside class="contact-section__sidebar">
                    <h2 class="heading2">Contact Me</h2>
                    <div class="contact-info">
                        <h3>Nola Swartz</h3>
                        <!-- <p>&lpar;865&rpar; 000-0000</p> -->
                        <p><a class="mail-link" href="mailto:nola@mjmconsultingtn.com">nola@mjmconsultingtn.com</a></p>
                    </div>
                    <img src="/public/assets/img/nola_portrait.webp" class="contact-portrait" alt="Nola Swartz" />
                </aside>
                <div class="contact-section__main">
                    <form id="contact-form" autocomplete="off">
                        <div class="grid grid--2">
                            <div class="form-group">
                                <div class="text-field">
                                    <input type="text" name="first-name" id="first-name" class="text-field__input" placeholder=" "/>
                                    <label for="first-name" class="text-field__label">First Name</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-field">
                                    <input type="text" name="last-name" id="last-name" class="text-field__input" placeholder=" "/>
                                    <label for="last-name" class="text-field__label">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-field">
                                <input type="email" name="email" id="email" class="text-field__input" placeholder=" "/>
                                <label for="email" class="text-field__label">Email</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-field">
                                <input type="text" name="subject" id="subject" class="text-field__input" placeholder=" "/>
                                <label for="subject" class="text-field__label">Subject</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="message-body" id="message-body" class="textarea" placeholder="Your Message Here..."></textarea>
                        </div>
                        <ul class="errbox"></ul>
                        <div class="form-group">
                            <button type="submit" class="subbut">Submit</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <footer class="footer">
        <small>&copy;2025 MJM Consulting</small>
        <p>Custom website by <a href="https://www.haydenbradfield.com/">Hayden Bradfield</a></p>
    </footer>
    <script>
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

                const response = await fetch('/process_contact_form.php', {
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
    </script>
</body>
</html>