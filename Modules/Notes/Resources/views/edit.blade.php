

        <div class="container-fluid">
                @if($customer)
                    <span>{{ $customer->name }}  </span>
                @endif

                <ul>
                @foreach($customer->notes()->get() as $note)
                   <li> {{ $note->description }} </li>
                @endforeach
                </ul>
        </div>
