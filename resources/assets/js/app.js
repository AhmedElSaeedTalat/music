
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
Vue.component(
    'receive',
    require('./components/receive.vue')
);
Vue.component(
    'payment',
    require('./components/payment.vue')
);
Vue.component(
    'socket',
    require('./components/socket.vue')
);
Vue.component(
    'pusher',
    require('./components/pusher.vue')
);
Vue.component(
    'admin',
    require('./components/adminWindow.vue')
);
Vue.component(
    'chat',
    require('./components/fullChat.vue')
);

const app = new Vue({
    el: '#app',
    data:{
    	acceptIndex:[],
    	rejectIndex:[],
        grant_type:"",
        events:[],
        index:0,
        paused:false,
        player:true,
        volume:"",
        seek:"",
        midValue:0.5,
        hightVolume:true,
        lowerVolume:false,
        mute:false,
        seek1:"",
        seek2:"",
        albums:false,
        bio:true,
        event:false,
        acceptWord:true,
        rejectWord:true,
        chatWindow:false,
        chatFacade:true,
        tips:true,
    },
    mounted()
    {
        
      
         /**
         *
         *  ensure seek bar start from zero
         *  for dispalyed songs
         *
         *  events page 
         */

         let seekBar = document.getElementsByClassName('seek');
         for (var i = 0; i < seekBar.length; i++) 
        {
            seekBar[i].value = 0;    
        }

        /**
         *  to display events on load 
         *
         *  events passed to the variable 
         */
        axios.get("/eventsonload").then(response => this.events = response.data );
    },
    computed:{
        paginations()
        {

        },
         /**
         * here we check the selected grant_type
         *
         *  if the selected grant_type is refresh_token
         * we wel show a field to enter the token
         */
        checkGrant_type()
        {
            if(this.grant_type == 'refresh_token')
            {
                return true;
            }
        },
        adult()
        {

        }
    },
    methods:{

   /**
     *  open sub menu
     *
     *  MenuPage
     */
        openSubMenu(e)
        {
           $(e.target).parent().next().slideToggle();
           $(e.target).parent().parent().toggleClass('noChildren');
           $(e.target).toggleClass('fa-plus');
           $(e.target).toggleClass('fa-minus');
        },

    /**
     *  open burnger menu in small screen
     *
     *  MenuPage
     */

        openSmallMenu()
        {
            $("#data").toggle();
            $(".menuMobile").toggle("slide");
        },
        closeMenuMobile(e)
        {
            $("#data").toggle();
            $(".menuMobile").toggle("slide");
        },
    /**
     *  this function to accept vendor 
     *  request to be part of the business
     *
     *  here is pushed the indexes of the 
     *  accepted vendors in one array
     */
        accept(index,id)
    	{
    	this.rejectIndex = this.rejectIndex.filter(function(i){
    		return i !== index;
    	})	;
    	if(this.acceptIndex.indexOf(index) > -1 ){
    		return ;
    	} else {
	    	this.acceptIndex.push(index);
            $(".accepts").eq(id).replaceWith("<i class='fa fa-check accepts' aria-hidden='true'></i>");
            $(".rejects").eq(id).replaceWith("<p class='color_white accept rejects'>reject</p>");

    	}
    	},

        /**
         *  this function to reject vendor 
         *  request to be part of the business
         *
         *  here is pushed the indexes of 
         *  the rejected vendors in one array
         */

    	reject(index,id)
    	{	
    	this.acceptIndex = this.acceptIndex.filter(function(i){
    		return i !== index;
    	});		
    	if(this.rejectIndex.indexOf(index) > -1 ){
    		return;
    	} else {
    		this.rejectIndex.push(index);
            $(".rejects").eq(id).replaceWith(' <i class="fa fa-times rejects" aria-hidden="true"></i>');
            $(".accepts").eq(id).replaceWith(" <p class='color_white accept accepts secondArg'>accept</p>");

    	}
    	},
        
        /**
         *  this function to post information in 
         *  db about the accepted vendors and rejected one
         *
         *  you can see that we created a client 
         *  for each accepted vendor while at it 
         */

    	saveChanges()
    	{
    		axios.post("/requestsprocessed",{
    			acceptIndexes : this.acceptIndex,
    			rejectIndexes : this.rejectIndex
    		}).then(response => console.log(response.data));
    		for (var i =0; i < this.acceptIndex.length ; i++) {
    			axios.post("/oauth/clients",{
    			name:"vendor",
    			redirect: 'http://localhost:8000',
    		 });	
    		}
    		axios.post("/xx",{
    			vendor: this.acceptIndex.length
    		}).then(response => console.log(response.data));
    		this.acceptIndex = [] ;
    		this.rejectIndex = [] ;
    	},

           /**
             *  receives events data based on 
             *  selected page
             *
             *  here is pushed the indexes of the 
             *  accepted vendors in one array
             */

            paginate(e,id)
            {
              $(e.target).addClass('pagination');
              $(e.target).siblings().removeClass('pagination');
                axios.post('/events',{
                    index:id
                }).then(response => this.events = response.data);
            },

             /**
             *  custome sound track settings
             *
             *  index is used to track selected audio
             */

            play(index)
            {
                var x = "#player" + index;
                $(x)[0].play();
                $(".fa-play").eq(+index-1).css("display","none");
                $(".fa-pause").eq(+index-1).css("display","inline-block");
                //x.addEventListener('timeupdate',seektimeupdate);
            },
            pause(index)
            {
                var x = "#player" + index;
                $(x)[0].pause();
                $(".fa-pause").eq(+index-1).css("display","none");
                $(".fa-play").eq(+index-1).css("display","inline-block");
                console.log(document.getElementById('player').paused ==true);
            },
            changeVol(index)
            {
                 var x = "#player" + index;
                 $(x)[0].volume = this.volume;
                 if(this.volume > this.midValue)
                 {
                    $(".fa-volume-up").eq(+index-1).css("display","inline-block");
                    $(".fa-volume-down").eq(+index-1).css("display","none");
                    $(".fa-volume-off").eq(+index-1).css("display","none");
                 } else if(this.volume < this.midValue && this.volume > 0) {
                    $(".fa-volume-down").eq(+index-1).css("display","inline-block");
                    $(".fa-volume-up").eq(+index-1).css("display","none");
                    $(".fa-volume-off").eq(+index-1).css("display","none");

                 } else if(this.volume == 0)
                 {
                    $(".fa-volume-off").eq(+index-1).css("display","inline-block");
                    $(".fa-volume-up").eq(+index-1).css("display","none");
                    $(".fa-volume-down").eq(+index-1).css("display","none");
                 }

            },

            /**
             *  calculate seeking for audio
             *
             *  events page
             */

            seeking(index)
            {
                let seek = $(".seek").eq(+index-1).val();
                var x = "#player" + index;
                let time =  $(x)[0].duration * seek/100;
                $(x)[0].currentTime = time;
                
            },

            /**
             *  change class of active menu
             *
             *  singers page
             */

             active1()
             {
                $("#active1").addClass('active');
                $('#active2').removeClass('active');
                 $('#active3').removeClass('active');
                this.bio = true;
                this.albums = false; 
                this.event = false;
                this.tips= true;
             },
             active2()
             {
                $("#active2").addClass('active');
                $('#active1').removeClass('active');
                $('#active3').removeClass('active');
                this.albums = true;
                this.bio = false;
                this.event = false;
                this.tips= false;
             },
               active3()
             {
                $('#active3').addClass('active');
                $("#active2").removeClass('active');
                $('#active1').removeClass('active');
                this.albums = false;
                this.bio = false;
                this.event = true;
                this.tips= false;
             },
            /**
             *  show chat window
             *
             *  queries page
             */
             showChat()
             {
                this.chatWindow = true;
                this.chatFacade = false;
             }
    }
});
