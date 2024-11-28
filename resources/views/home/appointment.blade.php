<section class="ftco-intro">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-3 color-1 p-4">
    				<h3 class="mb-4" font-weight: bold>Contact Us</h3>
    				<p>Have a concern? Our team is here to help. Reach out at:</p>
    				<span class="phone-number">+(63) 9054560625 /           +(63) 9760947795</span>
    			</div>
    			<div class="col-md-3 color-2 p-4">
    				<h3 class="mb-4" font-weight: bold>Opening Hours</h3>
    				<p class="openinghours d-flex">
    					<span>Monday </span>
    					<span>8:00 AM - 5:00 PM</span>
    				</p>
    				<p class="openinghours d-flex">
    					<span>Saturday</span>
    					<span>8:00 AM - 5:00 PM</span>
    				</p>
    				
    			</div>
           
           
                <div class="col-md-6 color-3 p-4" style="background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h3 id="quote-title" class="mb-3" style="text-align: center; color: #ffffff; font-weight: bold;"></h3>
    <!-- Display quote section -->
    <div id="quote-container" class="mb-3" style="text-align: center;">
        <blockquote id="quote-text" class="blockquote" style="font-style: italic; color: #ffffff; padding: 20px; ">
            <p id="quote-content" style="margin: 0; font-size: 1.2rem;"></p>
            <footer id="quote-author" style="margin-top: 10px; font-size: 1rem; color: #ffffff;"></footer>
        </blockquote>
    </div>
</div>

<script>
    //  dental quotes with authors separated
    const dentalQuotes = [
    { text: "\"A smile is the universal welcome.\"", author: "— Max Eastman" },
    { text: "\"Every tooth in a man’s head is more valuable than a diamond.\"", author: "— Miguel de Cervantes" },
    { text: "\"Dental health is essential for your overall well-being.\"", author: "— Unknown" },
    { text: "\"A dentist at work in his vocation always looks down in the mouth.\"", author: "— George Bernard Shaw" },
    { text: "\"Tooth decay is worse than a broken heart.\"", author: "— Unknown" },
    { text: "\"A healthy smile is a beautiful smile.\"", author: "— Unknown" },
    { text: "\"Brushing and flossing are not only good for your teeth but good for your overall health.\"", author: "— Unknown" },
    { text: "\"The best way to predict your future is to create it, one smile at a time.\"", author: "— Unknown" },
    { text: "\"Your smile is the first thing people notice about you.\"", author: "— Unknown" },
    { text: "\"Good dental hygiene is a habit that pays off in more ways than one.\"", author: "— Unknown" },
    { text: "\"Take care of your teeth, and they will take care of you.\"", author: "— Unknown" },
    { text: "\"Every day is a fresh start, and so is every new smile.\"", author: "— Unknown" },
    { text: "\"Smile, and the world will smile with you.\"", author: "— Unknown" },
    { text: "\"A beautiful smile is a sign of a healthy body and mind.\"", author: "— Unknown" },
    { text: "\"Your teeth are an important part of your body. Take care of them as you would any other part of yourself.\"", author: "— Unknown" },
    { text: "\"A smile is the best makeup any girl can wear.\"", author: "— Marilyn Monroe" },
    { text: "\"Oral health is the key to a better quality of life.\"", author: "— Unknown" },
    { text: "\"A smile can brighten even the darkest day.\"", author: "— Unknown" },
    { text: "\"Every smile is unique; let yours shine.\"", author: "— Unknown" },
    { text: "\"Dental health is an investment, not an expense.\"", author: "— Unknown" },
    { text: "\"Good habits make great smiles.\"", author: "— Unknown" },
    { text: "\"Start your day with a smile, and make it shine.\"", author: "— Unknown" },
    { text: "\"The mouth is the gateway to overall health.\"", author: "— Unknown" }
];


    //  dentist facts
    const dentistFacts = [
        "Dentists recommend brushing your teeth twice a day for at least two minutes each time.",
        "The first toothbrush with bristles was made in China in 1498.",
        "Tooth enamel is the hardest substance in the human body.",
        "Flossing helps reduce the risk of gum disease by removing plaque from areas that a toothbrush can’t reach.",
        "Dental X-rays can help detect cavities, tumors, cysts, and bone loss.",
        "The average person spends 38.5 days brushing their teeth over their lifetime.",
        "Chewing sugar-free gum after meals can help promote saliva production, which helps clean the teeth.",
        "Your mouth contains more bacteria than there are people on the Earth.",
        "The most common dental problem is cavities, which are preventable with good oral hygiene.",
        "Your teeth start to develop even before you’re born, starting as early as the sixth week of pregnancy.",
        "A dental cleaning at the dentist is recommended every six months to maintain good oral health.",
        "Electric toothbrushes can remove more plaque and reduce gum disease more effectively than manual brushing.",
        "Gingivitis is the earliest stage of gum disease and can be treated with good oral hygiene.",
        "Wisdom teeth are the last set of molars to come in, typically in the late teens or early 20s.",
        "Dental braces were first used in Ancient Egypt and Greece to straighten teeth."
    ];

    let currentType = 'quote'; // Tracks the current type being displayed

    // Function to display a random dental quote
    function displayRandomQuote() {
        document.getElementById('quote-title').innerText = 'Dental Quote of the Day';
        const randomIndex = Math.floor(Math.random() * dentalQuotes.length);
        document.getElementById('quote-content').innerText = dentalQuotes[randomIndex].text;
        document.getElementById('quote-author').innerText = dentalQuotes[randomIndex].author;
    }

    // Function to display a random dental fact
    function displayRandomFact() {
        document.getElementById('quote-title').innerText = 'Dental Facts';
        const randomIndex = Math.floor(Math.random() * dentistFacts.length);
        document.getElementById('quote-content').innerText = dentistFacts[randomIndex];
        document.getElementById('quote-author').innerText = ''; // No author for facts
    }

    // Display a quote when the page loads
    displayRandomQuote();

    // Update the quote every day (86400000 milliseconds)
    setInterval(displayRandomQuote, 86400000);

    // Update the fact every hour (3600000 milliseconds)
    setInterval(displayRandomFact, 3600000);
</script>





    		</div>
    	</div>
    </section>