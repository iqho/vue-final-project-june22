<template>
    <div class="container px-3" v-if="isLoggedIn">
        <div v-if="succMessage" class="row g-0">
            <div class="col-12 text-center">
                <h3  class="text-success">{{ succMessage }}</h3>
            </div>
        </div>

        <h3>Checkout ( {{ $store.getters.cartCount }} )</h3>

        <div class="row g-0">
            <div class="col-md-8">
                <CartItem />
            </div>

            <div class="col-md-4">
                <div class="container ms-2">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Shipping Address</div>
                        </div>
                        <div class="card-body">

                            <div class="form-group mb-2">
                                <label for="shippingFullName">Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" id="shippingFullName"
                                    v-model="shippingFullName" autofocus required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="shippingContactNumber" class="form-label">Contact Number</label>
                                <input type="tel" pattern="[0-9]" class="form-control no-arrow"
                                    placeholder="01xxxxxxxxx" id="shippingContactNumber" v-model="shippingContactNumber"
                                    required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="shippingAddress" class="form-label">Full Address</label>
                                <textarea class="form-control" placeholder="Full Address" v-model="shippingAddress"
                                    required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">Billing Address</div>
                        </div>
                        <div class="card-body pt-1">

                            <div class="col-12">
                                <div class="form-check p-0 pb-1 mt-0 pt-0 text-left d-flex align-items-center">
                                <input type="checkbox" class="me-2" id="checkbox" v-model="sameAddress" @change="autoFill" style="height:28px; width: 20px" />
                                <label for="checkbox" class="fs-6"> Same as Shipping Address</label>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="billingFullName">Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" id="billingFullName"
                                    v-model="billingFullName" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="billingContactNumber" class="form-label">Contact Number</label>
                                <input type="tel" pattern="[0-9]" class="form-control no-arrow"
                                    placeholder="01xxxxxxxxx" id="billingContactNumber" v-model="billingContactNumber"
                                    required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="billingAddress" class="form-label">Full Address</label>
                                <textarea class="form-control" placeholder="Full Address" id="billingAddress" v-model="billingAddress"
                                    required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            Payment Method
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <select class="form-select shadow-none" v-model="paymentMethod"
                                    @change="changePaymentMethod($event)" required>
                                    <option value="">Select Payment Method</option>
                                    <option v-for="(paymentMethod, index) in paymentMethods" :key="index" :value="paymentMethod.id">{{ paymentMethod.name }}</option>
                                </select>

                                <div class="row g-0 mt-2 p-1">
                                    <div v-if="paymentMethod === 1" class="col-12"
                                        :class="showPaymentForm ? 'd-block' : 'd-none'">
                                        <select class="form-select shadow-none mb-1" v-model="mobileBankingType">
                                            <option value="" selected>Select Mobile Banking Type</option>
                                            <option value="bkash">Bkash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="rocket">Rocket</option>
                                            <option value="others">Others</option>
                                        </select>
                                        <div class="mb-2">
                                            <label for="mobile-banking-account-number" class="form-label">Account
                                                Number</label>
                                            <input type="number" class="form-control shadow-none"
                                                id="mobile-banking-account-number" placeholder="Account Number" v-model="mobileBankingAccountNumber">
                                        </div>
                                        <div class="mb-2">
                                            <label for="mobile-banking-transaction-number"
                                                class="form-label">Transaction Number</label>
                                            <input type="number" class="form-control shadow-none"
                                                id="mobile-banking-transaction-number" placeholder="Transaction Number" v-model="mobileBankingTransactionNumber">
                                        </div>
                                    </div>

                                    <div v-if="paymentMethod === 2" class="col-12"
                                        :class="showPaymentForm ? 'd-block' : 'd-none'">
                                        <div class="mb-2">
                                            <label for="bank-name" class="form-label">Bank Name</label>
                                            <input type="text" id="bank-name" class="form-control shadow-none mb-1"
                                                placeholder="Bank Name" v-model="bankName">
                                        </div>
                                        <div class="mb-2">
                                            <label for="bank-account-number" class="form-label">Bank Account
                                                Number</label>
                                            <input type="text" id="bank-account-number"
                                                class="form-control shadow-none mb-1" placeholder="Bank Account Number" v-model="bankAccountNumber">
                                        </div>
                                        <div class="mb-2">
                                            <label for="bank-branch-name" class="form-label">Branch Name</label>
                                            <input type="text" in="bank-branch-name"
                                                class="form-control shadow-none mb-1" placeholder="Branch Name" v-model="bankBranchName">
                                        </div>
                                    </div>

                                    <div v-if="paymentMethod === 3" class="col-12"
                                        :class="showPaymentForm ? 'd-block' : 'd-none'">
                                        <div class="mb-2">
                                            <label for="card-holder-name" class="form-label">Card Holder Name</label>
                                            <input type="text" dir="card-holder-name" name="card-holder-name"
                                                class="form-control" placeholder="Card Holder Name" v-model="cardHolderName" />
                                        </div>
                                        <div class="mb-2">
                                            <label for="card-number" class="form-label">Card Number</label>
                                            <input type="number" id="card-number" name="card-number"
                                                class="form-control" placeholder="Card Number" v-model="cardNumber"/>
                                        </div>
                                        <div class="mb-2">
                                            <label for="card-expire-date" class="form-label">Card Expired Date</label>
                                            <input type="month" id="card-expire-date" name="card-expire-date"
                                                class="form-control" placeholder="Card Expire Date" v-model="cardExpiredDate" />
                                        </div>
                                        <div class="mb-2">
                                            <label for="card-cvv" class="form-label">CVV</label>
                                            <input type="number" id="card-cvv" name="card-cvv"
                                                class="form-control" placeholder="CVV" v-model="cardCvv" />
                                        </div>
                                    </div>

                                    <div v-if="paymentMethod == 4" class="col-12"
                                        :class="showPaymentForm ? 'd-block' : 'd-none'">
                                        <div class="mb-2">
                                            <label for="paypal-email" class="form-label">Paypal Email</label>
                                            <input type="text" id="paypal-email" name="paypal-email"
                                                class="form-control" placeholder="Paypal Email" v-model="paypalEmail" />
                                        </div>
                                        <div class="mb-2">
                                            <label for="paypal-amount" class="form-label">Paypal Amount</label>
                                            <input type="number" id="paypal-amount" name="paypal-amount"
                                                class="form-control" placeholder="Paypal Amount" v-model="paypalAmount"/>
                                        </div>
                                    </div>

                                    <div v-if="paymentMethod == 5" class="col-12"
                                        :class="showPaymentForm ? 'd-block' : 'd-none'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-0 mt-3">
                        <div class="col-md-12 text-center">
                            <button @click="confirmOrder" class="btn btn-lg btn-primary">Confirm Order</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import CartItem from '../components/CartItem.vue';
        
export default {
    name: 'Checkout',
    data() {
        return {
            succMessage: '',
            cartCount: 0,
            paymentMethods: [],
            total_amount: 0,

            shippingFullName: this.$store.getters.getUserData.name || this.$store.getters.getUserName,
            shippingContactNumber: this.$store.getters.getUserData.contact_number || this.$store.getters.getUserNumber,
            shippingAddress: this.$store.getters.getUserData.parmanent_address || this.$store.getters.getUserAddress,

            billingFullName: '',
            billingContactNumber: '',
            billingAddress: '',

            paymentMethod: '',

            mobileBankingType: '',
            mobileBankingAccountNumber: '',
            mobileBankingTransactionNumber: '',
            
            bankName: '',
            bankAccountNumber: '',
            bankBranchName: '',

            cardHolderName: '',
            cardNumber: '',
            cardExpiredDate: '',
            cardCvv: '',

            paypalEmail: '',
            paypalAmount: '',

            cashOnDeliveryAmount: '',
            
            showPaymentForm: false,
            sameAddress: false
        }
    },

    components: {
        CartItem
    },
    
    mounted() {
        
        axios.get('http://127.0.0.1:8000/api/api-payment-methods')
        .then(response => {
            this.paymentMethods = response.data.paymentMethods;
        })
        .catch(error => {
            console.log(error);
        })   
    },

    computed: {
        isLoggedIn: function () {
            if(this.$store.getters.isLoggedIn){
                return true;
            }
            else{
                this.$router.push('/login')
            }
        },
    },
    
    methods: {
        changePaymentMethod(event) {
            let paymentMethod = event.target.value;
            if (paymentMethod) {
                this.showPaymentForm = true
            }
            //console.log(paymentMethod);
        },

        autoFill(){
            if(this.sameAddress == true){
                this.billingFullName = this.shippingFullName;
                this.billingContactNumber = this.shippingContactNumber;
                this.billingAddress = this.shippingAddress;
            }
            else {
                this.billingFullName = ''
                this.billingContactNumber = ''
                this.billingAddress = '';
            }
       },
       
     
        confirmOrder(){
        
            const data={
                cartItems: this.$store.getters.storeCart,
                total_amount: this.$store.getters.totalAmount,

                shippingFullName: this.shippingFullName,
                shippingContactNumber: this.shippingContactNumber,
                shippingAddress: this.shippingAddress,

                billingFullName: this.billingFullName,
                billingContactNumber: this.billingContactNumber,
                billingAddress: this.billingAddress,

                paymentMethodId: this.paymentMethod,

                mobileBankingType: this.mobileBankingType,
                mobileBankingAccountNumber: this.mobileBankingAccountNumber,
                mobileBankingTransactionNumber: this.mobileBankingTransactionNumber,

                bankName: this.bankName,
                bankAccountNumber: this.bankAccountNumber,
                bankBranchName: this.bankBranchName,
                cardHolderName: this.cardHolderName,
                cardNumber: this.cardNumber,
                cardExpiredDate: this.cardExpiredDate,
                cardCvv: this.cardCvv,
                paypalEmail: this.paypalEmail,
                paypalAmount: this.paypalAmount,
                cashOnDeliveryAmount: this.cashOnDeliveryAmount,
              
            }

            axios.post('http://127.0.0.1:8000/api/api-orders', data).then(response => {
                if(response.data.success){
                    console.log(response.data.success);
                    this.$store.dispatch("clearCart");
                    this.succMessage = response.data.success
                     setTimeout(() => this.succMessage = '', 5000);
                }
                else {
                    console.log(response.data.errors);
                }
            }).catch(error => {
                console.log(error);
            });
        }
     
    }

}
</script>

<style scoped>
.no-arrow {
    -moz-appearance: textfield;
}

.no-arrow::-webkit-inner-spin-button {
    display: none;
}

.no-arrow::-webkit-outer-spin-button,
.no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>