;(function () {
	let KEY = 'infility-global_infility-form_keyword';
	window.addEventListener('load', function (event) {
		var keyword = new URLSearchParams(window.location.search).get('keyword');
		if (keyword) {
			console.log('[Infility Global Plugin - Infility Form] found keyword: ' + keyword);
			let existed = window.localStorage.getItem(KEY);
			if (!existed) {
				window.localStorage.setItem(KEY, keyword);
			} else {
				let keywords = existed.split(',');
				if (keywords.indexOf(keyword) === -1) {
					keywords.push(keyword);
					window.localStorage.setItem(KEY, keywords.join(','));
				}
			}
			console.log('[Infility Global Plugin - Infility Form] all keywords: ' + window.localStorage.getItem(KEY));
		}
	})
})();
