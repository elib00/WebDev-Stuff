const codes = {
    "01A": ["Alpha", "Beta", "Gamma"],
    "01B": ["Gamma", "Baby"]
}

let words;

function isValid(){
    for(let word of words){
        if(!(word in codes)){
            alert("Please input a valid jeepney code")
            return false
        }
    }

    return true;
}

function handleSubmit(){
    let input = document.getElementById("input_id")
    words = input.value.split(",");

    for(let i = 0; i < words.length; i++){
        words[i] = words[i].trim();
    }
    
    validInput = isValid();
    if(validInput == false){
        return false;
    }

    alert("Valid input " + input.value)

    let output = document.getElementById("output_box")
    //output.innerHTML = "testing..."

    let res = ""

    for(const word of words){
        res += "<p>"
        for(let i = 0; i < codes[word].length; i++){
            if(i == codes[word].length - 1){
                res += `<span>${codes[word][i]}</span>`
            }else{
                res += `<span>${codes[word][i]} -> </span>`
            }
        }
        res += "</p>"
    }
    
    output.innerHTML = res
}
