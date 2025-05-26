function showSelectedPickupPoint(inputId, labelId, point) {
	if (!!point) {
		document.getElementById(inputId).value = JSON.stringify(point);

		let packetaName = [];
		if ('place' in point) {
			packetaName.push(point.place);
		}
		if ('nameStreet' in point) {
			packetaName.push(point.nameStreet);
		} else if ('name' in point) {
			packetaName.push(point.name);
		}
		document.getElementById(labelId).innerHTML = packetaName.join(', ');
	}
}
