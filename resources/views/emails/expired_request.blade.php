Dear Mr./Ms. {{ $user->name }} <br><br>

Your request has been EXPIRED:<br><br>

- Device: {{ $device->name }}<br>
- Project: {{ $project->name }}<br>
- Request date: {{ $request->start_time->format('Y/m/d') }}<br>
- Expiration date: {{ $request->end_time->format('Y/m/d') }}<br><br>

Please access this link for more details:<br>
- Link: {{ route('requests.show', $request->id) }}<br><br>

Best regards,