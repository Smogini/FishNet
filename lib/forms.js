function formhash(form, password) {
    // Crea un elemento di input che verrà usato come campo di output per la password criptata.
    console.log("Prima della creazione");
    let p = document.createElement("input");
    // Aggiungi un nuovo elemento al tuo form.
    console.log("Dopo creazione - prima append");
    form.appendChild(p);
    p.name = "psw";
    p.type = "hidden"
    p.value = hex_sha512(password.value);
    // Assicurati che la password non venga inviata in chiaro.
    password.value = "";
    // Come ultimo passaggio, esegui il 'submit' del form.
    form.submit();
}