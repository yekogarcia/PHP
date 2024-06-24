// import puppeteer from 'puppeteer';

const puppeteer = require('/home/yeko/workspace/pupeters/node_modules/puppeteer');

var arg = process.argv.slice(2)

const generatePdf = function () {

    (async () => {
        const browser = await puppeteer.launch();
        const page = await browser.newPage();

        await page.goto('https://developer.chrome.com/');

        // Set screen size
        await page.setViewport({ width: 1080, height: 1024 });

        // Type into search box
        await page.type('.search-box__input', 'automate beyond recorder');

        // Wait and click on first result
        const searchResultSelector = '.search-box__link';
        await page.waitForSelector(searchResultSelector);
        await page.click(searchResultSelector);

        // Locate the full title with a unique string
        const textSelector = await page.waitForSelector(
            'text/Customize and automate'
        );
        const fullTitle = await textSelector.evaluate(el => el.textContent);

        const pdf = await page.pdf({ format: 'A4' });
        await page.addStyleTag({ content: 'h4 { BACKGROUND-COLOR:  #016f90} ' });
        await page.pdf({
            printBackground: true,
            path: arg[0],
            format: "Letter",
            margin: {
                top: "20px",
                bottom: "40px",
                left: "20px",
                right: "20px"
            }
        });

        // Print the full title
        console.log('The title of this blog post is "%s".', fullTitle);

        await browser.close();
    })();
}

generatePdf();