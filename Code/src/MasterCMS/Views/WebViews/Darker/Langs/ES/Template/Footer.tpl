        <div id="hotel" class="hidden-sm-down"> </div>
        <footer>
        	<p id="Links"><a href="{@url}/web/terms">Términos y Condiciones</a> | <a href="{@url}/web/cookies">Política de Privacidad</a></p>
        	<p id="Copyright"><strong>&copy; {@name} Hotel</strong> · Todos los derechos reservados a sus respectivos autores</p>
        	<p id="Devs">MasterCMS {@master_version} | Back-End: <b>Denzel Code (LxBlack)</b> | Front-End: <b>Yonier (HabboAdictos1)</b></p>
        </footer>
        <script type="text/javascript" src="{@cdn}/JS/jquery.min.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/bootstrap.min.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/alertify.min.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/unslider.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/General.js"></script>        
        <script type="text/javascript" src="{@cdn}/JS/adblock.js"></script>
        <?php if ($this->request->getMethod() == 'index' && !$this->users->getSession()) { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/login.js"></script>
        <script type="text/javascript" src="{@cdn}/JS/forms/forgot.js"></script>
        <?php } ?>
        <?php if ($this->facebook->getSession() && $this->users->get('facebook_completed') == 0) { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/fbname.js"></script>
        <?php } ?>
        <?php if ($this->request->getMethod() == 'register' && !$this->users->getSession()) { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/register.js"></script>
        <?php } ?>        
        <?php if ($this->request->getMethod() == 'flash' && $this->users->getSession()) { ?>
        <script src="{@cdn}/JS/flash_detect_min.js"></script>
        <?php } ?>        
        <?php if ($this->request->getMethod() == 'index' && $this->users->getSession()) { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/refers.js"></script>
        <?php } ?>
        <?php if ($this->request->getMethod() == 'forgot_password' && !$this->users->getSession()) { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/forgot_password.js"></script>
        <?php } ?>
        <?php if ($this->request->getMethod() == 'news' && $this->request->getController() == 'web') { ?>
        <script type="text/javascript" src="{@cdn}/JS/forms/comments.js"></script>
        <?php } ?>
        <script>
          function adBlockDetected() {
            window.location.href = '{@url}/web/adblock';
          }

          function adBlockNotDetected() {
            console.log('good');
          }
          
          if(typeof fuckAdBlock === 'undefined') {
            adBlockDetected();
          } else {
            fuckAdBlock.setOption({ debug: false });
            fuckAdBlock.onDetected(adBlockDetected).onNotDetected(adBlockNotDetected);
          }

          if (FlashDetect.installed) {
            window.location.href = '{@url}/web/client';
          }
        </script>
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
        <script>
        window.addEventListener("load", function(){
        window.cookieconsent.initialise({
          "palette": {
            "popup": {
              "background": "rgba(24, 27, 29, 0.55)"
            },
            "button": {
              "background": "#25d4b4",
              "text": "#fff"
            }
          },
          "theme": "edgeless",
          "content": {
            "message": "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> {@name} utiliza cookies para ofrecerte una mejor experiencia en nuestro servicio. Si utilizas nuestra web consideramos que aceptas su uso.",
            "dismiss": "Aceptar",
            "link": "Leer más"
          }
        })});
        </script>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '{@fb_app_id}',
              xfbml      : true,
              version    : 'v2.8'
            });
            FB.AppEvents.logPageView();
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
        <?php if ($this->request->getMethod() == 'settings' && $this->users->getSession()) { ?>
        <script>
            $(function() {
                $("#radioFR").buttonset();
                $("#radioOS").buttonset();
                $("#radioVE").buttonset();
                $("#radioTR").buttonset();
                $("#radioPR").buttonset();
                $("#radioEN").buttonset();
            });
        </script>
        <script>
            $(document).ready(function(){
                var activeNav = 0;                  

                $('.navButton').click(function(event) {
                    event.preventDefault();
                    if (activeNav == 0) {
                        activeNav = 1;
                        if ($('.navButton').hasClass('lf_Selected')) {
                            $('.navButton').removeClass('lf_Selected');
                        }
                        $(this).addClass('lf_Selected');

                        var target = $(this).attr('data-target'); 

                        $('.boxCont').hide(0, function() {
                            $(target).show(0, function () {
                                activeNav = 0;
                            });
                        });
                    }
                });

            });
        </script>
        <script type="text/javascript" src="{@cdn}/js/forms/settings.js"></script>
        <script type="text/javascript">
          $(document).ready(function() {
            generalForm();
                <?php if (!$this->users->get('facebook_account')) { ?>
            passwordForm();
                mailForm();
                <?php } ?>
                deleteForm();
          });
        </script>
        <?php } ?>
        <?php if ($this->request->getMethod() == 'forgot_password' || $this->request->getMethod() == 'verificate_mail') { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                setTimeout(function () {
                    window.location = '{@url}';
                }, 3000);
            });
        </script>
        <?php } ?>
        <?php if ($this->facebook->getSession() && $this->users->get('facebook_completed') == 0) { ?>
        <script>
          $(document).ready(function(){

            $('#fbModal').modal('show');

          });          
        </script>
        <?php } ?>
    </body>
</html>