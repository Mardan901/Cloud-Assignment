function checkReply(quoteId) {
    var allBoxes = document.querySelectorAll('textarea');
    for (var i = 0; i < allBoxes.length; i++) {
        allBoxes[i].required = false;
    }
    
    // to check what box user clicking
    var textBox = document.getElementById('reply_box_' + quoteId);
    
    // Check if it is empty
    if (textBox.value.trim() === "") {
        textBox.value = ""; // Clear out hidden spaces
        
        textBox.required = true; //make only current textbox required to make a change
        textBox.reportValidity(); //show error
        
        // remove the rule once user start input something
        textBox.addEventListener('input', function() {
            textBox.required = false;
        }, { once: true }); 
        
        return false; // stop the form from submitting
    }else{
    return true; 
    } 
}