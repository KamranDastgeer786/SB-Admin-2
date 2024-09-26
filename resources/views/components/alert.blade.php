<div>
    @if (Session::has('alerttt'))
        <script>
            $(document).ready(function() {
                var messageType = "{{ session('alerttt')['type'] ?? 'success' }}";
                var messageText = "{{ session('alerttt')['message'] }}";

                console.log(messageType, messageText);
                Swal.fire(
                    messageText,
                    '',
                    messageType
                );
            });
        </script>
        {{-- @dd(session()->all()) --}}
        @php
            Log::info(session()->all());
        @endphp
    @endif
</div>
