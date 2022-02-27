import sal from 'sal.js';


const initSal = {
    init(){
        document.addEventListener('DOMContentLoaded', event => {
            sal({
                threshold: 0.1
            });
        });
    }
}

export default initSal