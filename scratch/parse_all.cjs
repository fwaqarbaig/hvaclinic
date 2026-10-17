const fs = require('fs');

function extractArray(code, prefixRegex) {
    const match = code.match(prefixRegex);
    if (!match) return null;
    const bracketStart = match.index + match[0].indexOf('[');
    
    let depth = 0;
    let inString = false;
    let quoteChar = '';
    let endIdx = -1;
    
    for (let i = bracketStart; i < code.length; i++) {
        const char = code[i];
        const prev = i > 0 ? code[i - 1] : '';
        
        if (inString) {
            if (char === quoteChar && prev !== '\\') {
                inString = false;
            }
        } else {
            if (char === '"' || char === "'" || char === '`') {
                inString = true;
                quoteChar = char;
            } else if (char === '[') {
                depth++;
            } else if (char === ']') {
                depth--;
                if (depth === 0) {
                    endIdx = i;
                    break;
                }
            }
        }
    }
    
    if (endIdx !== -1) {
        return code.slice(bracketStart, endIdx + 1);
    }
    return null;
}

// 1. Industries
const indCode = fs.readFileSync('storage/industries_raw.txt', 'utf8');
const indArrayStr = extractArray(indCode, /\[\{id:/);
if (indArrayStr) {
    fs.writeFileSync('storage/industries_array.cjs', 'module.exports = ' + indArrayStr);
    try {
        const data = require('../storage/industries_array.cjs');
        fs.writeFileSync('storage/industries.json', JSON.stringify(data, null, 2));
        console.log('Industries extracted successfully! Total:', data.length);
    } catch (e) {
        console.log('Error requiring industries_array.cjs:', e.message);
    }
} else {
    console.log('Could not find industries array');
}

// 2. Locations
const locCode = fs.readFileSync('storage/locations_raw.txt', 'utf8');
const locArrayStr = extractArray(locCode, /\[\{name:/);
if (locArrayStr) {
    fs.writeFileSync('storage/locations_array.cjs', 'module.exports = ' + locArrayStr);
    try {
        const data = require('../storage/locations_array.cjs');
        fs.writeFileSync('storage/locations.json', JSON.stringify(data, null, 2));
        console.log('Locations extracted successfully! Total:', data.length);
    } catch (e) {
        console.log('Error requiring locations_array.cjs:', e.message);
    }
} else {
    console.log('Could not find locations array');
}

// 3. Used Generators
const usedCode = fs.readFileSync('storage/used_generators_raw.txt', 'utf8');
const usedArrayStr = extractArray(usedCode, /\[\{id:/);
if (usedArrayStr) {
    fs.writeFileSync('storage/used_generators_array.cjs', 'module.exports = ' + usedArrayStr);
    try {
        const data = require('../storage/used_generators_array.cjs');
        fs.writeFileSync('storage/used_generators.json', JSON.stringify(data, null, 2));
        console.log('Used Generators extracted successfully! Total:', data.length);
    } catch (e) {
        console.log('Error requiring used_generators_array.cjs:', e.message);
    }
} else {
    console.log('Could not find used generators array');
}
