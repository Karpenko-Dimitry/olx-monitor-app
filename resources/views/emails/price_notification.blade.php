<?php
 /** @var \App\Models\PriceEndpoint $endpoint*/
?>
@component('mail::message')
# The price in the ad you are following has changed

Price changed from {{ $endpoint->previous_price }} to {{ $endpoint->current_price }}
@component('mail::button', ['url' => $endpoint->url])
OlX advertisement
@endcomponent

Thanks for using our service
@endcomponent
