<script>
    @if (Auth::check())
        var tokenApiKey = "{!! Auth::user()->createToken('token')->plainTextToken  !!}"
    @endif
</script>
