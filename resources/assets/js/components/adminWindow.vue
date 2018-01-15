<template>
	<div>
		<div class="container mt-5 admins">
			<div class="row">
				<div class="col-12 ">
					<div class="adminWindow1">
						<form action="" @submit.prevent='adminSend1($event,index)' 
						v-if="message.user !='Admin'" class="formReply text-center">
							<input type="text" v-model="userWithComplaint" placeholder="user name" class="input">
							<input type="text" v-model="adminMessage" placeholder="message" class="input">
							<input type="submit" class="btn btn-warning">
							<div class="close" @click="closeChatBox"><i class="fa fa-times" aria-hidden="true"></i>
							</div>
						</form>
					</div>
					<i class="fa fa-cog" aria-hidden="true" v-show="settings" @click="showChatBox"></i>
					<div v-for="message,index in storedMessages" 

						:class="{adminMessage:message.user=='Admin',adminWindow:message.user!='Admin'}">
						<chat :client="message.user" ></chat>

						<div class="close1" @click="closeMessage($event)">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<p class="user">
							User: {{message.user}}
						</p>	
						<p class="mt-2">
							 {{message.message}}
							  <span class="timeTag">{{message.time}}</span>
						</p>
						<p class="text-right"  v-if="message.user =='Admin'"><strong>Queried By: {{message.userWithComplaint}}</strong></p>
					</div>

					<div v-for="message,index in messages" 

						:class="{adminMessage:message.user=='Admin',adminWindow:message.user!='Admin'}">
						<chat :client="message.user" ></chat>
						<div class="close1" @click="closeMessage($event)">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<p class="user">
							User: {{message.user}}
						</p>	
						<p class="mt-2">
							 {{message.message}}
							  <span class="timeTag">{{message.time}}</span>
						</p>
						<p class="text-right"  v-if="message.user =='Admin'"><strong>Queried By: {{message.userWithComplaint}}</strong></p>
						<form action="" @submit.prevent='adminSend($event,index)' 
						v-if="message.user !='Admin'" class="formReply text-right">
							<input type="text" v-model="userWithComplaint" placeholder="user name" class="input">
							<input type="text" v-model="adminMessage" placeholder="message" class="input">
							<input type="submit" class="btn btn-warning">
						</form>
					</div>
				</div><!-- col-12 -->
			</div><!-- row -->
		</div><!-- container -->
	</div>
</template>
<script>	
		export default{
			data(){
				return{
					messages:[],
					message:"",
					users:[],
					userWithComplaint:"",
					adminMessage:"",
					storedMessages:[],
					indexes:[],
					settings:false
				}
			},
		
			props:['authen'],
			mounted()
			{
			
				
		/**
		 *
		 * get stored data from session
		 * 
		 * 
		 */
		 
		 var x = this ;
			axios.get('/adminsession').then(response => response.data.message.map(function(info) {
				x.storedMessages.push(info);
			}));	
			

		/**
		 *
		 * listen to pusher event
		 * 
		 * provide messages from clients
		 */

			Echo.private('customerService')
				.listen('chating',(e)=>{
					this.messages.push({
						message:e.data,
						user:e.user,
						time:this.theTime()
					});
					axios.post('/clientadmin',{
						message:e.data,
						user:e.user,
						time:this.theTime(),
						chat_id:e.chat_id
					})
					})
			},

		/**
		 *
		 * warning message if he wants to leave the page
		 * 
		 */
		
			updated(){
					window.onbeforeunload = function(){
						  return 'Are you sure you want to leave?';
						};
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

				adminSend(e,index){
					
					this.messages.push({
				 	message:this.adminMessage,
				 	userWithComplaint:this.userWithComplaint,
			 		user: 'Admin',
			 		time:this.theTime(),
				 
				 });
				
				 axios.post('/adminSend',{
				 	message: this.adminMessage,
				 	userWithComplaint: this.userWithComplaint,
				 	time:this.theTime(),
				 	response:"done",
				 	index: index
				 });
				 	this.adminMessage = '';
				 	this.userWithComplaint = '';
				 	$(e.target).css('display','none');
				},
				adminSend1(e,index){
					
					this.messages.push({
				 	message:this.adminMessage,
				 	userWithComplaint:this.userWithComplaint,
			 		user: 'Admin',
			 		time:this.theTime(),
				 
				 });
				
				 axios.post('/adminSend',{
				 	message: this.adminMessage,
				 	userWithComplaint: this.userWithComplaint,
				 	time:this.theTime(),
				 	response:"done",
				 	index: index
				 });
				 	this.adminMessage = '';
				 	this.userWithComplaint = '';
				},

		/**
		 *
		 * calculate time the message was sent.
		 * 
		 */

			theTime(){
					let time = new Date();
					return time.getHours()+":"+time.getMinutes();
			},

		/**
		 *
		 * close form to submit messages
		 * 
		 */

			closeChatBox()
			{
				$(".adminWindow1").toggle("slide");
				this.settings = true;
			},

		/**
		 *
		 * show form to submit messages
		 * 
		 */
			
			showChatBox()
			{
				this.settings = false;
				$(".adminWindow1").toggle("slide");
			},

		/**
		 *
		 * close unneeded message
		 * 
		 */

			closeMessage(e)
			{
				$(e.target).parent().parent().toggle('slide');
			}
			}
		}
</script>