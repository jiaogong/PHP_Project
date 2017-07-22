@include('index.template.header')
	@section('content')
	<!--contact-starts-->
	<div class="contact">
		<div class="container">
			<div class="contact-top">
				<div class="col-md-4 contact-left heading">
					<h1>CONTACT US</h1>
					<p>Lorem ipsum dolsit met consetuer adipiscing dolor.</p>
				</div>
				<div class="col-md-8 contact-right">
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="contact-bottom">
				<div class="col-md-4 contact-left heading">
					<h2>CONTACT FORM</h2>
					<p>Lorem ipsum dolsit met consetuer adipiscing dolor.</p>
				</div>
				<div class="col-md-8 contact-right">
					<form action="{{ route('contact') }}" method="post">
						{{ csrf_field() }}
						@if(!Session::has('user_id'))
						<input type="text" name="name" value="Name" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Name';}" />
						<input type="text" name="email" value="Email" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Email';}" />
						@else
						<div>{{ Session::get('user_name') }}
							<span>talk:</span>
						</div>
						@endif
						<textarea value="Message:" name="content" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Message';}">Message..</textarea>
						<div class="submit-btn">
							<input type="submit" value="SUBMIT">
						</div>
					</form>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!----contact-end---->
	@show
@include('index.template.footer')
