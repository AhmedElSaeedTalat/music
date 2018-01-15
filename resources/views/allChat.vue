<template>
	<div>
		<div class="container">
			<div class="row">	
				<div class="col-6 col-xs-offset-4">	
					<div v-for="message in messages">
						<p>
							<span>{{message.user}}</span>
							{{message.message}}
						</p>	
						{{message.time}}
					</div>
		
		
		<form action="" @submit.prevent='sendData'>
			<input type="text" v-model='message'>
		</form>
				</div>
			</div>
	
		</div>
	
		
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
				leave:""
			}
		},
		props:['user'],
		mounted(){
			Echo.private('customerService')
				.listen('chating',(e)=>{
					this.messages.push({
						message:e.data,
						user:e.user,
						time:this.theTime()
					});
					})
					.listenForWhisper('typing', (e) => {
	    					if(e.name != '')
	    					{
	    						this.typing = e.name + "is typing";
	    					}else{
	    						this.typing = '';
	    					}
				});
					Echo.join('customerService')
	                .here((users) => {
	        				
	                 })
    				.joining((user) => {
	        				this.join = user.name;
	    				})
	    				.leaving((user) => {
	        				this.leave= user.name;
    				});
	    				
	        				
	  
		},
		watch:{
				message(){
					Echo.private('customerService')
   						 .whisper('typing', {
	        				name: this.user,
    					});
		
				}
				

		},
		methods:{
			sendData(){
				 this.messages.push({
				 	message:this.message,
			 		user: 'you',
			 		time:this.theTime(),
				 });
				
				 axios.post('/send',{
				 	message: this.message,
				 });
				 this.message = '';
			},
			theTime(){
				let time = new Date();
				return time.getHours()+":"+time.getMinutes();
			}
		}
	}
</script>