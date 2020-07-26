@extends('layouts.admin')

@section('content')

<div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Custom Message</h1>

          <div class="row">

            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 text-primary" style="display: inline-block;">Compose Message </i></h6>
                    <a href="#" data-toggle="modal" data-target="#smsinfoModal"><i class=" text-primary fas fa-info-circle" style="float: right"></i></a>
                    
                    </div>
                    <div class="card-body">
                                @if (Session::has('sms_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('sms_form_status')  }}
                                    </div> 
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sms.send') }} ">
                        @csrf
                            <div>
                            <h7 class="m-0 text-info">Recipients:</h7>
                            </div>
                            <div class="row">
                                
                                    <div class="col-xl-3">
                                        <i class="fas fa-user"></i>
                                        <label for="contact">Single Contact</label>
                                        <input type="text" id="singleContact" name="singleContact" class="form-control" maxlength="12" placeholder="e.g 254712345678">
                                    </div>
                                    
                                
                            </div>
                            <div>
                            <h7 class="m-0 text-info">Message</h7>
                            </div>
                            <div class="form-group">
                                <div class="col-xl-8">
                                    <div class="md-form">
                                    <i class="fas fa-pencil-alt prefix"></i>
                                    <textarea id="form22" name="message" class="md-textarea form-control" rows="5" style="border: 1px solid #186dd6" placeholder="Type message here..."></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                <div class="my-2"></div>
                                    <a href="javascript:$('form').submit();" name="send" class="btn btn-primary btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                            <i class="fas fa-paper-plane"></i>
                                            </span>
                                            <span class="text">Send</span>
                                    </a>
                                </div>
                                <div class="col-xl-6">

                                        <div class="my-2"></div>
                                        <a href="#" class="btn btn-primary btn-icon-split btn-sm disabled">
                                            <span class="icon text-white-50">
                                            <i class="fas fa-share-square"></i>
                                            </span>
                                            <span class="text">Send to all contacts</span>
                                        </a>
                                        <div class="my-2"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>
</div> 

<!-- About Custom SMS Modal -->
                <div class="modal " id="smsinfoModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 id="item_name" class="modal-title">Sending SMS</h4>
                            <button onclick="location.reload()" type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" id="modal_body">
                        <p>
                            You can use this interface to send a custom sms using M-Chama BulkSMS.<br><br>To send a message to a single contact,
                            Enter the number in the format indicated, type the messsage and hit send.<br><br>
                            
                        </p>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <h6>Need Help? Email to <a href="mailto: info@mchama.co.ke">support@mchama.co.ke</a><h6>
                        </div>
                        </div>
                    </div>
                    </div>
                    <!--modale end-->


@endsection