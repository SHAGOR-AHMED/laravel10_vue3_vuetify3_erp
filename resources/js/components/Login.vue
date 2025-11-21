<template>
    <div>
		<div class="login_view bg-dark">
			<div id="particle-container">
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
				<div class="particle"></div>
			</div>
			<div class="col-lg-4 col-md-8 col-12 div_center">
				<v-form>
	
					<v-card class="pb-4">
						<v-card-title class="justify-center">
							<v-avatar>
								<img src="/all-assets/common/logo/cpb/cplogo.png" alt="CPB-IT">
							</v-avatar>
							CPB-IT
						</v-card-title>
						<v-card-text>
	
	
							<form @submit.prevent="login_attempt()">
	
								<v-text-field type="text" label="Login ID" :rules="[v => !!v || 'Login ID is required!']"
									v-model="form.email" prepend-icon="mdi-account-alert-outline" required></v-text-field>
								<div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
	
								<v-text-field :type="passwordType ?'text': 'password'"
									:append-icon="passwordType ?'mdi-eye':'mdi-eye-remove'"
									@click:append="passwordType=!passwordType" label="Password"
									:rules="[v => !!v || 'Password is required!']" v-model="form.password"
									prepend-icon="mdi-lock-alert-outline" required></v-text-field>
								<div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
	
	
								<v-btn block depressed class="light-blue darken-4 text-black"
									type="submit">
									<v-icon dense>
										mdi-login
									</v-icon>
									Login
								</v-btn>
	
							</form>
	
						</v-card-text>
	
					</v-card>
	
				</v-form>
			</div>
		</div>
    </div>
</template>

<script>
// vform
import Form from 'vform'
export default {
    name: 'Login',
    data: function(){
        return {
            dataLodaing: false,
            loginForm:true,
            user_email:"",
            passwordType: false,

            nameRules: [
                v => !!v || 'Email is required',
            ],

            passwordRules: [
                v => !!v || 'Password is required',
            ],

            form: new Form({
                email: '',
                password: '',
            })
        }
    },

    methods: {
        login_attempt: function(){
            this.form.post('/login-check')
            .then(response =>{
                if(response.data.success == true){
                    window.location.href = "/admin/dashboard" //web.php route
                }else{
                    alert('Invalid Username or Password');
                    window.location.href = "/"
                }
            })
        },
    }

}
</script>


<style scoped lang="scss">

	.login_view {
		position: relative;
		width: 100vw;
		height: 100vh;
	}

	.div_center {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 9999;
	}

	/* animation */
    .particle {
        position: absolute;
        border-radius: 50%;
    }

    @for $i from 1 through 30 {
        @keyframes particle-animation-#{$i} {
            100% {
                transform: translate3d((random(90) * 1vw),
                        (random(90) * 1vh),
                        (random(100) * 20px));
            }
        }

        .particle:nth-child(#{$i}) {
            animation: particle-animation-#{$i} 60s infinite;
            $size: random(5) + 5 + px;
            opacity: random(100) / 100;
            height: $size;
            width: $size;
            animation-delay: -$i * 0.2s;
            transform: translate3d((random(90) * 1vw),
                    (random(90) * 1vh),
                    (random(100) * 1px));
            background: hsl(random(360), 70%, 50%);
        }
    }

	.v-dialog__container {
		display: block !important;
	}

	.login_form {
		height: 520px;
		width: 410px;
		/*background-color: rgba(255,255,255,0.13);*/
		background-color: #f1f1f1;
		position: absolute;
		transform: translate(-50%,-50%);
		top: 50%;
		left: 50%;
		border-radius: 10px;
		backdrop-filter: blur(10px);
		border: 2px solid rgba(255,255,255,0.1);
		box-shadow: 0 0 40px rgba(8,7,16,0.6);
		padding: 25px 25px;
	}

	.sub_button{
		background: linear-gradient(to bottom, #f0c368 0%, #ffd60a 50%, #feb645 100%) !important;
		border-radius: 5px;
		font-weight: 700;
	}

</style>