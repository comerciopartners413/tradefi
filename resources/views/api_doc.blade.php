
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="https://documenter.getpostman.com/" target="_blank">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="ownerId" content="2966719">
      <meta name="publishedId" content="SVYtMxi4">

      <meta name="description" content="The Tradefi-UBA API allows you to programmatically fetch data from or post data to the Tradefi-UBA application depending on the method of request.
Overview

The base endpoint is https://uba.tradefi.ng/api/. The full endpoints for each request type are shown in their respective sections below.

The Tradefi-UBA API will only respond to secured communication done over HTTPS. HTTP requests will be sent a 301 redirect to corresponding HTTPS resources.

Response to every request is sent in JSON format. In case the API request results in an error, it is represented by &amp;quot;status&amp;quot;: &amp;quot;error&amp;quot;, &amp;quot;message&amp;quot;: &amp;quot;...&amp;quot; in the JSON response.

The request method (verb) determines the nature of action you intend to perform. A request made using the GET method implies that you want to fetch something from the Tradefi application, and POST implies you want to save something new to the Tradefi application.


API Reference
">
    <meta name="generator" content="Postman Documenter">
      <title>TradeFi-UBA API</title>

    <!-- Google Tag Manager -->
    <script nonce="tRE+56N/y0nCUIDtke6UljPg6FT+eb2w5OuniaFHsaXSjkD9">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KCKQFT');</script>
    <!-- End Google Tag Manager -->

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/styles/production.min.css">
      <link rel="stylesheet" type="text/css" href="/styles/custom.scss?top-bar=FFFFFF&right-sidebar=303030&highlight=F6A821&">

    <link rel="shortcut icon" href="/favicon.ico" />

      <link rel="stylesheet" href="https://run.pstmn.io/button.css">

    <script src="/js/messenger-setup.js" nonce="tRE+56N/y0nCUIDtke6UljPg6FT+eb2w5OuniaFHsaXSjkD9"></script>
      <meta property="og:title" content="TradeFi-UBA API" />
      <meta property="og:description" content="The Tradefi-UBA API allows you to programmatically fetch data from or post data to the Tradefi-UBA application depending on the method of request.
Overview

The base endpoint is https://uba.tradefi.ng/api/. The full endpoints for each request type are shown in their respective sections below.

The Tradefi-UBA API will only respond to secured communication done over HTTPS. HTTP requests will be sent a 301 redirect to corresponding HTTPS resources.

Response to every request is sent in JSON format. In case the API request results in an error, it is represented by &amp;quot;status&amp;quot;: &amp;quot;error&amp;quot;, &amp;quot;message&amp;quot;: &amp;quot;...&amp;quot; in the JSON response.

The request method (verb) determines the nature of action you intend to perform. A request made using the GET method implies that you want to fetch something from the Tradefi application, and POST implies you want to save something new to the Tradefi application.


API Reference
" />
      <meta property="og:site_name" content="TradeFi-UBA API" />
      <meta property="og:url" content="https://documenter.getpostman.com/view/2966719/SVYtMxi4" />
      <meta property="og:image" content="https://res.cloudinary.com/postman/image/upload/w_152,h_56,c_fit,f_auto,t_team_logo/v1/team/768118b36f06c94b0306958b980558e6915839447e859fe16906e29d683976f0" />


      <meta name="twitter:title" value="TradeFi-UBA API" />
      <meta name="twitter:description" value="The Tradefi-UBA API allows you to programmatically fetch data from or post data to the Tradefi-UBA application depending on the method of request.
Overview

The base endpoint is https://uba.tradefi.ng/api/. The full endpoints for each request type are shown in their respective sections below.

The Tradefi-UBA API will only respond to secured communication done over HTTPS. HTTP requests will be sent a 301 redirect to corresponding HTTPS resources.

Response to every request is sent in JSON format. In case the API request results in an error, it is represented by &amp;quot;status&amp;quot;: &amp;quot;error&amp;quot;, &amp;quot;message&amp;quot;: &amp;quot;...&amp;quot; in the JSON response.

The request method (verb) determines the nature of action you intend to perform. A request made using the GET method implies that you want to fetch something from the Tradefi application, and POST implies you want to save something new to the Tradefi application.


API Reference
" />
    <meta name="twitter:card" content="summary">
      <meta name="twitter:domain" value="https://documenter.getpostman.com/view/2966719/SVYtMxi4" />
      <meta name="twitter:image" content="https://res.cloudinary.com/postman/image/upload/w_152,h_56,c_fit,f_auto,t_team_logo/v1/team/768118b36f06c94b0306958b980558e6915839447e859fe16906e29d683976f0" />
    <meta name="twitter:label1" value="Last Update" />
    <meta name="twitter:data1" value="" />
  </head>

  <body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCKQFT"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

    <div class="layout">
    
    
      <div class="modal" id="rawBodyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <button type="button" class="close btn-circle" data-dismiss="modal" aria-label="Close">
          <div>
            <span aria-hidden="true">×</span>
          </div>
        </button>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
            </div>
          </div>
        </div>
      </div>
    
      <div class="modal" id="snippetModal" tabindex="-1" role="dialog" aria-labelledby="documentation-response-modal">
        <button type="button" class="close btn-circle" data-dismiss="modal" aria-label="Close">
          <div>
            <span aria-hidden="true">×</span>
          </div>
        </button>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <pre><code></code></pre>
            </div>
          </div>
        </div>
      </div>
    
      <div class='container-fluid no-gutter'>
        <div class="row no-gutter">
          <div class="col-xs-12 info no-gutter">
            <div id="mobile-controls">
    
              <label>Environment</label>
                <div class="environment-dropdown dropdown">
                    <button class="btn pm-btn pm-btn-secondary dropdown-toggle" type="button" id="environment-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <div class="dropdown-button ellipsis active-environment" data-environment-id="undefined-22ee08fe-924a-45c7-a6e5-0bd606289362">UBALive</div>
    
                        <script src="/js/run-env-setup.js" nonce="tRE+56N/y0nCUIDtke6UljPg6FT+eb2w5OuniaFHsaXSjkD9" type="text/javascript" id="public-run-button-env"
                          data-env-name="UBALive"
                          data-env-values="[{&quot;key&quot;:&quot;url&quot;,&quot;value&quot;:&quot;https://uba.tradefi.ng&quot;,&quot;enabled&quot;:true}]"></script>
                      <span class="pm-doc-sprite pm-doc-sprite-dropdown-caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="environment-dropdown">
                        <li class="dropdown-menu-item" data-environment-id="0">No environment</li>
                        <li class="dropdown-menu-seperator"></li>
                        <li class="dropdown-menu-section">Shared Templates</li>
                        <li class="dropdown-menu-item dropdown-menu-empty" data-environment-id="undefined-undefined">No shared environments</li>
                        <li class="dropdown-menu-seperator"></li>
                        <li class="dropdown-menu-section">Private Environments</li>
                        <li class="dropdown-menu-item " data-environment-id="2966719-22ee08fe-924a-45c7-a6e5-0bd606289362">UBALive</li>
                    </ul>
                </div>
    
                <label>Language</label>
                <div class="language">
                  <div class="btn-group languages">
                    <button type="button" class="btn pm-btn pm-btn-secondary dropdown-toggle language-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <div class="active-lang ellipsis">cURL</div>
                      <span class="pm-doc-sprite pm-doc-sprite-dropdown-caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right language_dropdown">
                      <li class="dropdown-menu-item" data-snippetname=shell:curl>cURL</li>
                      <li class="dropdown-menu-item" data-snippetname=javascript:jquery>jQuery</li>
                      <li class="dropdown-menu-item" data-snippetname=ruby:native>Ruby</li>
                      <li class="dropdown-menu-item" data-snippetname=python:requests>Python Requests</li>
                      <li class="dropdown-menu-item" data-snippetname=node:native>Node</li>
                      <li class="dropdown-menu-item" data-snippetname=php:curl>PHP</li>
                      <li class="dropdown-menu-item" data-snippetname=go:native>Go</li>
                    </ul>
                  </div>
                </div>
    
            </div>
    
            <div id='error-view'>
            </div>
    
            <div id="doc-body" class="is-loading">
              <div class="initial-loader">
                <div class="spinner"></div>
                Just a moment...
              </div>
            </div>
          </div>
          <div class="no-gutter phantom-sidebar"></div>
          <div class="no-gutter sidebar" id="nav-sidebar"></div>
        </div>
      </div>
    </div>

    <script src="https://cdn.ravenjs.com/3.26.2/raven.min.js" nonce="tRE+56N/y0nCUIDtke6UljPg6FT+eb2w5OuniaFHsaXSjkD9" crossorigin="anonymous"></script>
    <script src="/js/production.min.js" nonce="tRE+56N/y0nCUIDtke6UljPg6FT+eb2w5OuniaFHsaXSjkD9" id="script-data-scope"
      data-var-user-id=""
      data-var-environment="production"
      data-var-team-id=""
      data-var-host=""
      data-var-version=""
      data-var-sentry-dsn="https://714c749bafde4552896bc6298c2c28a6@sentry.postmanlabs.com/11"></script>

  </body>
</html>