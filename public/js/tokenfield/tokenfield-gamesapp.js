// Platform
var platform = new Bloodhound({
    local: [ {value: 'PC'}, {value: 'PS4'}, {value: 'Xbox One'}, {value: 'Switch'}, {value: 'Other'}],
    datumTokenizer: function(d) {
        return Bloodhound.tokenizers.whitespace(d.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace
});

platform.initialize();

$('#inputPlatform').tokenfield({
    typeahead: [null, {
        source: platform.ttAdapter(),
        displayKey: 'value' }]
});