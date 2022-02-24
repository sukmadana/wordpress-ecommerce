const $ = window.jQuery;
const $window = window.$window || $(window);

class SingleProductAjax{
    constructor() {
        let wrapper = document.querySelectorAll('.product-single-item')
        if (!document.body.contains(wrapper[0])) {
            return false
        }
        this.materialChange()
        this.checkSelectValue()
    }

    checkSelectValue(){
        let button = document.querySelector('button[name="add-to-cart"]')
        let materialSelect = document.getElementById('product_material')

        if (materialSelect.value === '') {
            button.classList.add('button-disable')
        } else {
            if (button.classList.contains('button-disable')) {
                button.classList.remove('button-disable')
            }
        }
    }

    checkSelect(){
        let ready = false;
        let materialSelect = document.getElementById('product_material').value

        if ( materialSelect !== ''){
            ready = true
        }

        return ready;
    }

    materialChange(){
        let materialSelect = document.getElementById('product_material')
        let id = document.querySelector('button[name="add-to-cart"]').value
        

        materialSelect.addEventListener('change', (e)=>{
            let isReady = this.checkSelect()
            this.checkSelectValue()
            if (isReady) {
                this.runAjax(id, materialSelect.value)
            }
        })
    }

    runAjax(id, material){
        let price = document.querySelector('.price')
        const data = new FormData();
        data.append('action', 'product_set_price');
        data.append('product_id', id);
        data.append('material_name', material);

        let fetchData = {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: data
        };

        fetch(ajaxurl, fetchData)
            .then(response => {
                return response.json();
            })
            .then(data => {
                console.log(data[0]);
                price.innerHTML = `
                <span class="woocommerce-Price-amount amount">
                <bdi>
                <span class="woocommerce-Price-currencySymbol">Rp</span>
                ${data[0]}
                </bdi>
                </span>
                `
            })
            .catch(err => {
                // eslint-disable-next-line no-console
                console.log(err);
            });
    }

};

export default SingleProductAjax;