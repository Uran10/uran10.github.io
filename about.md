---
layout: default
title: About
---
<div class="card">
		<img src="assets/images/Immagine_about.jpg" alt="Roberto M. anni fa..." />
		<div class="content" style="padding: 8px; font-size: 14px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;">
			<h2>Ciao...</h2>
			<p>
				<b>Sono</b> questo nella foto a sinistra (quello grande), mi chiamo Roberto M...censura... 
			</p>
			<div id="counter">Ho <b>46 anni</b>.</div>
			<p>
				Sono uno sviluppatore di soluzioni web in .net. 
			<br/>
				Non ho molto da dire di me stesso se non che ho una moglie, 2 figli e un gatto.<br> 
				<b>Vivo</b> nella provincia di Lodi anche se lavoro a Piacenza.
			</p>
			<p>
				I miei <b>hobby</b> sono fotografia, leggere libri <i>soprattutto di fantascienza</i> e manga di vario genere, netflix&chill e navigare il web in cerca di roba nerd.
			</p>
			<p>
				Ho aperto questo blog <b>perchè</b> ero annoiato/volevo uno spazio mio/volevo una valvola di sfogo/bat-caverna... 
				non lo so nemmeno io, ma a volte ho viglia di scrivere quello che trovo su internet o che ho letto o visto, 
				ma di cui difficilmente potrei parlarne in giro senza sembrare un pazzo.
			</p>
			<hr>
			<p>
				Foto: <a href="https://glass.photo/uranio">glass.photo</a><br>
				Reddit: <a href="https://www.reddit.com/user/uranio/">user/uranio/</a>
			</p>

    <script>
        // 1. IMPOSTA LA TUA DATA DI PARTENZA QUI (Anno, Mese-1, Giorno, Ore, Minuti, Secondi)
        // Nota: I mesi in JavaScript partono da 0 (0 = Gennaio, 1 = Febbraio, ecc.)
        const dataPartenza = new Date(1980, 8, 18, 0, 0, 0); 

        function aggiornaContatore() {
            const oraAttuale = new Date();
            
            // Calcolo iniziale della differenza di data
            let anni = oraAttuale.getFullYear() - dataPartenza.getFullYear();
            let mesi = oraAttuale.getMonth() - dataPartenza.getMonth();
            let giorni = oraAttuale.getDate() - dataPartenza.getDate();
            let ore = oraAttuale.getHours() - dataPartenza.getHours();
            let minuti = oraAttuale.getMinutes() - dataPartenza.getMinutes();
            let secondi = oraAttuale.getSeconds() - dataPartenza.getSeconds();

            // Gestione del prestito dei secondi
            if (secondi < 0) {
                secondi += 60;
                minuti--;
            }
            // Gestione del prestito dei minuti
            if (minuti < 0) {
                minuti += 60;
                ore--;
            }
            // Gestione del prestito delle ore
            if (ore < 0) {
                ore += 24;
                giorni--;
            }
            // Gestione del prestito dei giorni (tiene conto dei giorni effettivi del mese precedente)
            if (giorni < 0) {
                // Trova l'ultimo giorno del mese precedente
                const mesePrecedente = new Date(oraAttuale.getFullYear(), oraAttuale.getMonth(), 0);
                giorni += mesePrecedente.getDate();
                mesi--;
            }
            // Gestione del prestito dei mesi
            if (mesi < 0) {
                mesi += 12;
                anni--;
            }

            // Formattazione del testo da mostrare nella pagina
            document.getElementById('counter').innerHTML = 
                `Ho esattamente <b>${anni} anni</b>, ${mesi} mesi, ${giorni} giorni, <br>` +
                `${ore} ore, ${minuti} minuti e ${secondi} secondi`;
        }

        // Avvia il contatore subito all'apertura della pagina
        aggiornaContatore();
        
        // Aggiorna il contatore ogni secondo (1000 millisecondi)
        setInterval(aggiornaContatore, 1000);
    </script>
		</div>
</div>
<hr>
