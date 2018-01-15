<template>
	<div>
		<div class="queryFullChat">
			<button @click="showFullChat">Full Chat</button>
		</div>
		<div class="fullChat" v-show='fullChat'>
			<div class="bg_hover fullChatHeader">
				<span>Full Chat</span>
			</div>
			<div class="body" v-chat-scroll>
				<div v-for="message in chat" class="eachMessage">
					<p class="fullChatBody"><strong v-if="message.adminMessage != null">Admin:</strong>
					{{message.adminMessage}}</p>
					<p class="fullChatBody"><strong v-if="message.ClientMessage != null">{{client}}:</strong> {{message.ClientMessage}}</p>
				</div>
			</div>	
			<div class="closeFullChat" @click='closeFullChat'>
				<i class="fa fa-times" aria-hidden="true"></i>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				fullChat:false,
				chat:[],
			}
		},
		mounted(){

		},
		props:['client'],
		methods:{
			showFullChat()
			{
				this.fullChat = true;
				axios.post("/chatfull",{
					id: this.client,
 				}).then(response => this.chat = response.data);
			},
			closeFullChat()
			{
				this.fullChat=false;
			}
		}
	}
</script>