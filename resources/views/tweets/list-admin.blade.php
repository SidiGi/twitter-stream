<div class="row">
	<div class="form-group">
		<a class="btn btn-primary reload">Reload</a>
	</div>
	<div class="form-group row">
		<div class="col-xs-2">
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="auto-reload">
				<label class="form-check-label" for="auto-reload">Auto reload</label>
			</div>
		</div>
		<div class="col-xs-2">
			<input type="number" class="form-control seconds" id="exampleInputPassword1" placeholder="Seconds" value="5">
		</div>
	</div>
</div>
<br>
<div class="ajax-wr">
	<form action="/approve-tweets" method="post" class="tweet-form">
		{{ csrf_field() }}

		@foreach($tweets as $tweet)
			<div class="tweet row">
				<div class="col-xs-8">
					@include('tweets.tweet')
				</div>
				<div class="col-xs-4 approval">
					<label class="radio-inline">
						<input
								type="radio"
								name="approval-status-{{ $tweet->id }}"
								value="1"
								class="approve-action"
								@if($tweet->approved)
								checked="checked"
								@endif
						>
						Approved
					</label>
					<label class="radio-inline">
						<input
								type="radio"
								name="approval-status-{{ $tweet->id }}"
								value="0"
								class="approve-action"
								@unless($tweet->approved)
								checked="checked"
								@endif
						>
						Unapproved
					</label>
				</div>
			</div>
		@endforeach
		<div class="row">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-primary form-sbt hidden" value="Approve Tweets">
			</div>
		</div>
	</form>

	<div class="row">
		{!! $tweets->links() !!}
	</div>
</div>

<script>
    var reload = function(){
        $.ajax({
            url: location.href,
            beforeSend: function() {
                $('.ajax-wr form').css({
                    'opacity': '.2',
                })
            },
            complete: function() {
                $('.ajax-wr form').css({
                    'opacity': '1',
                })
            }
        })
        .done(function(data){
            $('.ajax-wr form').html($(data).find('.ajax-wr form').html());
        });
    };

    $(function(){
        $(document).on('click', '.reload', function(event){
            event.preventDefault();
            reload();
        });

        var seconds = $('.seconds').val();
        var interval = setInterval(function(){
            if ($('#auto-reload').prop('checked')){
                reload();
            }
        }, seconds * 1000);

        $(document).on('change', '.seconds', function(event){
            seconds = $(this).val();

            clearInterval(interval);
            interval = setInterval(function(){
                if ($('#auto-reload').prop('checked')){
                    reload();
                }
            }, seconds * 1000);
        });

        $(document).on('change', '.approve-action', function(event){
            event.preventDefault();

            var _this = $(this),
                form = $('.tweet-form'),
                name = _this.attr('name'),
                data = {
                    '_token': form.find('[name="_token"]').val(),
                };
            data[name] = _this.val();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: data,
                beforeSend: function() {
                    _this.closest('.tweet').css({
                        'opacity': '.1',
                    })
                },
                complete: function() {
                    _this.closest('.tweet').css({
                        'opacity': '1',
                    })
                }
            }).done(function(data){
                console.log(data);
            });
            return false;
        })
    });
</script>