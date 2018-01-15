<template>
	<div>
	<section class="chating">
		<div class="container">
			<div class="row d-flex justify-content-center">	
				<div class="col-10 col-sm-6 col-lg-3 chatWindow">
				<div class="chatBody"  v-chat-scroll>
					<p class="mt-5 eachMessage"><strong>Admin:</strong> Hi I am here to serve you, How can I help</p>
					<div v-for="msg in storedMessages">
						<p class="eachMessage" v-if="message.userWithComplaint == user || message.user == 'you' ">
							<strong>{{msg.user}}:</strong>
							<span>{{msg.message}}</span>
							<span class="timeTag gfgf">{{msg.time}}</span>
						</p>
	
					</div>	
					<div v-for="message in messages">
						<p v-if="message.userWithComplaint == user || message.user == 'you' " class="eachMessage">
							<strong>{{message.user}}:</strong>
							<span>{{message.message}}</span>
							<span class="timeTag">{{message.time}}</span>
						</p>	
					 </div>
				</div>	
				<form action="" @submit.prevent='sendData'>
					<input type="text" v-model='message' class="chatInput" placeholder="enter you query here">
				</form>
				</div>
			</div>
	
		</div>
	</section>

		
	</div>
</template>
<script>
	export default{
		data(){
			return{
				messages:[],
				message:"",
				users:[],
				typing:"",
				join:"",
				leave:"",
				storedMessages:[]
			}
		},
		props:['user'],
		computed:{
			userWithComplaint(){
				return this.user;
			}
		},
		mounted(){		


		axios.get('/chat').then(response => this.storedMessages=response.data);
		/**
		 *
		 * listen to pusher event
		 * 
		 * provide messages from admins
		 */			
	  	
	  		Echo.private('customerService')
				.listen('chating',(e)=>{
					this.messages.push({
						message:e.data,
						user:"Admin",
						userWithComplaint: e.userWithComplaint,
						time:this.theTime()

					});
					axios.post('usersession',{
							adminMessage: e.data,
							user: "Admin",
							userWithComplaint: e.userWithComplaint,
							time: this.theTime()
						});
					});

		},
		methods:{
		
		/**
		 *
		 * push messages to array to be 
		 *  printed on the page 
		 * 
		 * send the messages to pusher to 
		 * broadcast it later
		 */

			sendData(){
				 this.messages.push({
				 	message:this.message,
			 		user: 'you',
			 		time:this.theTime(),
				 });
				
				 axios.post('/send',{
				 	message: this.message,
				 	user: this.user,
				 	time: this.theTime(),
				 });
					this.message = '';
			},

		/**
		 *
		 * calculate time the message was sent.
		 * 
		 */

			theTime(){
					let time = new Date();
					return time.getHours()+":"+time.getMinutes();
			}
		}
	}
</script>