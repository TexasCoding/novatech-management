<template>
    <div>
        <h2>Dashboard</h2>
        <div>
            Available Products: {{productCount}}
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        mounted() {
            this.getProductCount();
        },
        methods: {
            getProductCount() {
                const self = this;
                axios.get('http://novatech.test/api/products/inventory/count')
                    .then(response => {
                        self.productCount = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        data() {
            return {
                productCount: 0
            }

        }
    }
</script>