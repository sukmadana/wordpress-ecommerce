class Checkout {
    constructor() {
        let wrapper = document.querySelector('#send-enquiry')

        if (!document.body.contains(wrapper)) {
            return false
        }

        this.sendInquiry()
    }

    sendInquiry(){
        let btn = document.getElementById('send-enquiry')

        document.addEventListener('click', (e)=> {
            if (e.target.id == 'send-enquiry') {
            this.runAjax()
            }
            
        })
    }

    runAjax(){
        let form = document.querySelector('form[name="checkout"]')
        let notifEl = document.querySelector('.ajax-notification')

        const formData = new FormData(form);
        formData.append('action', 'send_inquiry_data');
        document.body.classList.add('ajax-loading')

        let fetchData = {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: formData
        };

        fetch(ajaxurl, fetchData)
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data) {
                    document.body.classList.remove('ajax-loading')
                    notifEl.innerHTML = '<span class="notif-success">Thank you for contacting us. One of our colleagues will get back in touch with you soon!Have a great day!</span>'
                }
            })
            .catch(err => {
                // eslint-disable-next-line no-console
                console.log(err);
            });
    }
}

export default Checkout