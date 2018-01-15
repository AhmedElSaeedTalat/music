<template>
	<div>
		<div class="row" style="background: #15171d;">
				<div class="col-3 col-lg-2">
					<p>id</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>age</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>price</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>number of Tickets</p>
				</div>
				<div class="col-lg-2 subTotal">
					<p>subtotal</p>
				</div>
				<div class="col-lg-2 subTotal">
					<p>total</p>
				</div>
			</div>
			<div class="row" style="background: #0e0e0e;">
				<div class="col-3 col-lg-2">
					<p>1</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>Adult</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>${{adult}}</p>
				</div>
				<div class="col-3 col-lg-2 d-flex align-items-center">
					<input type="number" class="number" placeholder="number of tickets" v-model='input_adult'>
				</div>
				<div class="col-3 col-lg-2 subTotal">
					<p>${{calc_adult}}</p>
				</div>
			</div>
			<div class="row" style="background: #15171d;">
				<div class="col-3 col-lg-2">
					<p>2</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>Child</p>
				</div>
				<div class="col-3 col-lg-2">
					<p>${{child}}</p>
				</div>
				<div class="col-3 col-lg-2 d-flex align-items-center">
					<input type="number" class="number" placeholder="number of tickets" v-model='input_child'>
				</div>
				<div class="col-3 col-lg-2 subTotal">
					<p>${{calc_child}}</p>
				</div>
				<div class="col-3 col-lg-2 subTotal">
					<p>${{total}}</p>
				</div>
			</div>
			<div class="row onlySmallCalc d-flex align-items-center"  style="background: #0e0e0e;">
				<div class="col-4 d-flex align-items-center">
					<p>Total</p>
				</div>
				<div class="col-xs-offset-6 col-2 d-flex align-items-center">
					<p>${{total}}</p>
				</div>
			</div>
		</div>
</template>

<script>
	export default
	{
		props:['adult','child'],
		data(){
			return {
				input_child:"",
				input_adult:""
			}
		},
		computed:{
			calc_adult()
			{
				return this.adult*this.input_adult;
			},
			calc_child()
			{
				return this.child*this.input_child;
			},
			total()
			{
				return +this.calc_adult + +this.calc_child;
			}
		}
	}
</script>