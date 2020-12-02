<script>
$(document).ready(function () {
        
        @foreach( session('toasts', collect())->toArray() as $toast)
   


            flash("{{ $toast["message"] }}", "{{ $toast["type"] }}");

        @endforeach


        @foreach ($errors->all() as $error)
            flash("{{ $error }}", "danger");
        @endforeach

            
   
});

</script>

{{ session()->forget('toasts') }}