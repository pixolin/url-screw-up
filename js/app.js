// WordPress function for i18n
const { __, _x, _n, _nx } = wp.i18n;

//run onsubmit if user submits form entry
window.addEventListener('DOMContentLoaded', function () {
	document.getElementById('anonymizer').addEventListener('submit', onsubmit);
});

onsubmit = (event) => {
	event.preventDefault();

	// read user input from form field
	const userinput = document.querySelector('[name="urlanon"]').value;

	if (userinput === '') {
		return false;
	}

	// split URL in parts to get the hostname
	try {
		url = new URL(userinput);

		toAnonymize = url.hostname;
		parts = toAnonymize.split('.');
		domain = parts[parts.length - 2];

		// replace middle of hostname to anonymize URL
		if (domain.length < 8) {
			domain = domain[0] + '...' + domain[domain.length - 1];
		} else {
			domain =
				domain.slice(0, 3) +
				'...' +
				domain.slice(domain.length - 3, domain.length);
		}
	} catch (err) {
		// print error message, if no valid URL is entered
		anonurl.innerHTML =
			'<p><mark>' +
			__('Invalid URL.', 'url-screw-up') +
			'</mark> ' +
			__('Please enter as', 'url-screw-up') +
			' <pre>https://example.com/{path/to/file.html}</pre></p>' +
			'<p class="error">' +
			err +
			'</p>';
	}

	parts[parts.length - 2] = domain;

	// join parts of the URL
	newDomain =
		url.protocol +
		'//' +
		parts.join('.') +
		url.port +
		url.pathname +
		url.search +
		url.hash;

	// copy URL to clipboard
	navigator.clipboard.writeText(newDomain);

	// print anonymized URL
	let output = '<p>' + __('Copied to clipboard:', 'url-screw-up') + '</p>';
	output += '<pre><mark>' + newDomain + '</mark></pre>';
	anonurl.innerHTML = output;
};
