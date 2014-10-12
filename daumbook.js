var daumbook;
(function(){
	var URL = "http://apis.daum.net/search/book?apikey=@key@&output=json&searchType=isbn&q=@isbn@&callback=";
	daumbook = function( ISBN, APIKEY ){
		return function(){
			bs.js( function( data ){
				var d;
				console.log( ISBN, APIKEY, data );
				if( data && data.channel && !bs.Dom( '#daumbook' + ISBN ).S('@href') ){
					d = data.channel.item[0];
					bs.Dom( '#daumbook' + ISBN ).S( '@href', d.link,
					'>', '<img style="margin:5px;width:100px;float:left;border:0;padding:0" src="' + d.cover_l_url + '" onerror="this.src=\'/bs/bsJSshow/0.3/book/noimage.png\';"/>', 
					'>', '<div class="daumbook0">'+
							'<div><strong>저자</strong> ' + d.author + ' | <strong>역자</strong> ' + d.translator + '</div>' +		
							'<div><strong>출판사</strong> ' + d.pub_nm + ' | <strong>출판일</strong> ' + d.pub_date + '</div>' +
							'<div><strong>가격</strong> ' + d.list_price + '</div>' +
							'<div>' + d.description + '</div>' +
						 '</div>',
					'>', '<br clear="all"/>'
					);
				}
			}, URL.replace( /[@]key[@]/, APIKEY ).replace( /[@]isbn[@]/, ISBN ) );
		};
	};
})();