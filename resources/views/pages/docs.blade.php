@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="h3 mb-0 text-gray-800">API Documentation</h3>
          </div>

            <div class="card">
                <div class="card-header">M-Chama APIs</div>
                <div class="card-body">
                    <h4> Documentation coming soon...</h4>
                    <p>For now use the below button to import the postman collection and get to know how to hit the API Endpoints...</p>

                    <div class="postman-run-button"
                        data-postman-action="collection/import"
                        data-postman-var-1="c70d62a64019d19b411d"></div>
                        <script type="text/javascript">
                          (function (p,o,s,t,m,a,n) {
                            !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
                            !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
                              (n = o.createElement("script")),
                              (n.id = s+t), (n.async = 1), (n.src = m), n
                            ));
                          }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
                        </script>

                
                </div>
                <div class="card-footer">For any queries mail <a href="mailto:me@jeffreykingori.dev">devsupport@mchama.co.ke</a> </div>
            </div>
        




@endsection