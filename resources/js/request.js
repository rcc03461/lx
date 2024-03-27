export async function request(url, options = {}) {

    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    };

    options = {...defaultOptions, ...options };


    const response = await fetch(url, options);
    const data = await response.json();
    return data;
}
