@extends('layouts.admin')

@section('content')

<div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Post Notice</h1>

          <div class="row">

            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 text-primary" style="display: inline-block;">New notice to all members </i></h6>
                    <a href="#" data-toggle="modal" data-target="#smsinfoModal"><i class=" text-primary fas fa-info-circle" style="float: right"></i></a>
                    
                    </div>
                    <div class="card-body">
                                @if (Session::has('notice_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('notice_form_status')  }}
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.notices.post') }}">
                        @csrf
                        
                            <div>
                            <h7 class="m-0 text-info">Annnouncement</h7>
                            </div>
                            <div class="form-group">
                                <div class="col-xl-8">
                                    <div class="md-form">
                                    <i class="fas fa-pencil-alt prefix"></i>
                                    <textarea id="form22" name="message" class="md-textarea form-control" rows="5" style="border: 1px solid #186dd6" placeholder="Type notice here..."></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                <div class="my-2"></div>
                                    <a href="javascript:$('form').submit();" name="send" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                        <i class="fas fa-paper-plane"></i>
                                        </span>
                                        <span class="text">Post</span>
                                    </a>
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
                            <h4 id="item_name" class="modal-title">Posting a Notice</h4>
                            <button onclick="location.reload()" type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" id="modal_body">
                        <p>
                            You can use this interface to post a notice to all M-Chama members.<br><br>To post a notice,
                            enter the message in the text area and hit the post button.<br><br>
                            
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