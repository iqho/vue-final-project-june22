<template>

    <div class="row g-0">

        <div v-if="isLoggedIn" class="col-12 text-center">
            <div class="card">
                <div class="card-header text-center pb-1"><h4>Welcome </h4></div>
                <div class="card-body">
                <div class="row g-0">
                    <div class="col-12">
                    <h4>You are logged in</h4>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-12">
                    <button
                        class="btn btn-primary"
                        style="width: 180px; font-size: 20px"
                        @click="onLogout">
                        Logout
                    </button>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div v-else class="col-12 d-flex justify-content-center">
            <div class="col-sm-12 col-md-6">
                <div class="card w-100">
                <div class="card-header text-center pb-1 pt-0 fs-4">Register</div>
                <div class="card-body">

                    <div class="row g-0 mb-3" v-if="registerErr">
                        <div v-for="(name, i) in registerErr.name" :key="i" class="col-12 alert alert-danger p-1 m-1" role="alert">        
                            {{ name }}    
                        </div>
                        <div v-for="(email, i) in registerErr.email" :key="i" class="col-12 alert alert-danger p-1 m-1" role="alert">        
                            {{ email }}    
                        </div>
                        <div v-for="(password, i) in registerErr.password" :key="i" class="col-12 alert alert-danger p-1 m-1" role="alert">        
                            {{ password }}    
                        </div>
                        <div v-for="(confirmPassword, i) in registerErr.confirmPassword" :key="i" class="col-12 alert alert-danger p-1 m-1" role="alert">        
                            {{ confirmPassword }}    
                        </div>
                    </div>

                    <form @submit.prevent="onSubmitRegisterForm">
                    
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name*</label>
                            <input type="text" class="form-control" id="name" v-model="name" required autofocus >
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address*</label>
                            <input type="text" class="form-control" id="email" v-model="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" id="password" v-model="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" id="confirmPassword" v-model="confirmPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Contact Number ( Optional )</label>
                            <input type="text" class="form-control" id="contactNumber" v-model="contactNumber">
                        </div>
                        <div class="mb-3">
                            <label for="parmanentAddress" class="form-label">Parmanent Address ( Optional )</label>
                            <input type="text" class="form-control" id="parmanentAddress" v-model="parmanentAddress">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:180px; font-size:20px">Register</button>
                    </form>
                    <div class="row g-0 mt-2">
                        <div class="col-12">
                            Already have an account ?
                            <router-link to="/login" style="text-decoration: none">Login</router-link> here
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {

    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            contactNumber: '',
            parmanentAddress: '',
            errors: ''
        }
    },
    
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn;
        },

        registerErr(){
            return this.$store.getters.getRegisterErrors ;
        }
    },

    methods:{
        onSubmitRegisterForm(){
            if(this.name === '' || this.email === '' || this.password === '' || this.confirmPassword === ''){
                alert('Email or Password can\'t be Empty');
                return;
            }

            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                confirmPassword: this.confirmPassword,

                contact_number: this.contactNumber,
                parmanent_address: this.parmanentAddress

            };
            this.$store.dispatch("register", data);
        },
    
        onLogout() {
            this.$store.dispatch("logout");
        }
    },

};
</script>

<style>
</style>
