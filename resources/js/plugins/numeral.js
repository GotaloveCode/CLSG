import Vue from 'vue';
export function Numeral() {
    Vue.number = {
        format(value) {
            let numeral = require('numeral');

            if (Number.isInteger(value)) {
                return numeral(value).format('0,0');
            }

            return numeral(value).format('0,0.00');
        }
    };

    Object.defineProperties(Vue.prototype, {
        $number: {
            get() {
                return Vue.number;
            }
        }

    });
}
