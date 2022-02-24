class Checkout {
    constructor() {
        let wrapper = document.querySelector('.woocommerce-checkout')

        if (!document.body.contains(wrapper)) {
            return false
        }

        this.sendInquiry()
    }

    sendInquiry(){
        let btn = document.getElementById('send-enquiry')

        document.addEventListener('click', (e)=> {
            e.preventDefault()
            if (e.target == btn || e.target.closest == '#send-enquiry') {
                console.log('object');
            this.runAjax()
            }
            
        })
    }

    runAjax(){
        let dataForm = document.querySelector('.woocommerce-checkout')
        const data = new FormData(dataForm);
        data.append('action', 'send_inquiry_data');

        console.log(data);

        // let fetchData = {
        //     method: 'POST',
        //     headers: {
        //         'X-Requested-With': 'XMLHttpRequest'
        //     },
        //     credentials: 'same-origin',
        //     body: data
        // };

        // fetch(ajaxurl, fetchData)
        //     .then(response => {
        //         return response.json();
        //     })
        //     .then(data => {
        //         console.log(data);
        //     })
        //     .catch(err => {
        //         // eslint-disable-next-line no-console
        //         console.log(err);
        //     });
    }
}

export default Checkout