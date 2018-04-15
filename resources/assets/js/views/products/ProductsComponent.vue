<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <router-link
                        tag="li"
                        class="nav-item nav-link"
                        active-class="active"
                        :to="{name: 'products.dashboard'}"
                        exact>
                    <font-awesome-icon :icon="tach"/>
                    Dashboard
                </router-link>
                <router-link
                        tag="li"
                        class="nav-item nav-link"
                        active-class="active"
                        :to="{name: 'products.inventory.add'}"
                        exact>
                    <font-awesome-icon :icon="plus"/>
                    Inventory
                </router-link>
                <router-link
                        tag="li"
                        class="nav-item nav-link"
                        active-class="active"
                        :to="{name: 'ebid_categories.add'}"
                        exact>
                    <font-awesome-icon :icon="folder"/>
                    Ebid Categories
                </router-link>
                <router-link
                        tag="li"
                        class="nav-item nav-link"
                        active-class="active"
                        :to="{name: 'bonanza_categories.add'}"
                        exact>
                    <font-awesome-icon :icon="folder"/>
                    Bonanza Categories
                </router-link>
                <router-link
                        tag="li"
                        class="nav-item nav-link"
                        active-class="active"
                        :to="{name: 'categories.get'}"
                        exact>
                    <font-awesome-icon :icon="folder"/>
                    Get Categories
                </router-link>
            </ul>
        </div>

        <div class="card-body">
            <h1 v-if="$route.path === '/products'">Novatech Product Management</h1>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    // Font Awesome
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
    import faTachometerAlt from '@fortawesome/fontawesome-free-solid/faTachometerAlt';
    import faPlusCircle from '@fortawesome/fontawesome-free-solid/faPlusCircle';
    import faFolder from '@fortawesome/fontawesome-free-solid/faFolder';
    import faSpinner from '@fortawesome/fontawesome-free-solid/faSpinner';


    export default {
        computed: {
            tach() {
                return faTachometerAlt
            },
            plus() {
                return faPlusCircle
            },
            folder() {
                return faFolder
            },
            spinner() {
                return faSpinner
            }
        },
        components: {
            FontAwesomeIcon,
        }
    }
</script>