@include('layouts.head')

@include('layouts.subhead')
<div class="app-main">
	@include('layouts.nav')

	<!-- page content -->
	<div class="app-main__outer">
		@yield('content')
		@include('layouts.footer')
	</div>
</div>

	<!-- /page content -->
<!-- footer content -->

@include("layouts.foot")