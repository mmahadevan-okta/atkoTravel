<script>

	function displayWidget() {

		var oktaSignIn = new OktaSignIn({
			baseUrl: '%oktaBaseURL%',
			logo: '%logo%',
			features: {
				rememberDevice: false,
				multiOptionalFactorEnroll: true,
				smsRecovery: true
			},
		  
		// OIDC options
		clientId: 'YYUAPHIAj3JPPO6yJans',
		redirectUri: '%sessionManager%', // need to investigate further

		authScheme: 'OAUTH2',
		authParams: {
			responseType: 'id_token',
			responseMode: 'okta_post_message',
			scope: [
				'openid',
				'email',
				'profile',
				'address',
				'phone'
			]
		},
		idpDisplay: 'PRIMARY',
		idps: [{
			'type': 'FACEBOOK',
			'id': '0oa1w1pmezuPUbhoE1t6'
			}]
		});

		oktaSignIn.renderEl(
			{ el: '#okta-login-container' },
		  	function (res) {
		    	if (res.status === 'SUCCESS') { 

					console.log("the OIDC token is: ");

					console.dir(res);

					// window.location = "http://localhost:8888/atkotravel/";

					window.location = "%sessionManager%";

				}
			}
		);
	}

	window.onload = displayWidget;

</script>