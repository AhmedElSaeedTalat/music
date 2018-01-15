<template>
	<div>
		<form action="" @submit.prevent="Something">
			<input type="text" v-model="message">
			<input type="submit">
		</form>
		<p>{{data.phrase}}</p>
	</div>
</template>
<script>
	export default
	{
		mounted()
		{
			
		},
		data()
		{
			return{
				message:"",
				data:[],
			}
		},
		methods:{
			Something()
			{
				
			}
		}
	}
</script>