@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.communication.title_singular') }}
    </div>

    <div class="card-body">
        
        <form method="POST" id="create-communication" action="{{ route("admin.communications.store") }}" enctype="multipart/form-data">
        @csrf
        @include('admin.communications.form', ['from'=>'create'])
        

        <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
                <!-- input type="hidden" name="images[]" id="images"/ -->
            </div>
        </form>
    </div>
</div>
@endsection


@section('template-level-scripts')

@parent
<script src="{{ asset('global/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/admin/communications.js') }}"></script>
<script src="{{ asset('js/admin/communications.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('global/scripts/components-bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>




@endsection

@section('template-level-styles')
@parent
<link href="{{ asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@stop

@section('page-level-scripts')
<script src="{{ asset('global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}"></script>
<script src="{{ asset('global/plugins/cubeportfolio/js/jquery.cubeportfolio.js') }}"></script>
<script src="{{ asset('global/plugins/owl.carousel.min.js') }}"></script>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.communicationMessageJs.init('create-communication');
    });
</script>
@endsection