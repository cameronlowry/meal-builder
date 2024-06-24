export const chunkArray = (arr, size) => {
    const chunks = Array.from({ length: Math.ceil(arr.length / size) }, (v, i) => arr.slice(i * size, i * size + size));
    const lastChunk = chunks[chunks.length - 1];
    
    if (lastChunk.length < size) {
        const remainingItems = size - lastChunk.length;
        const padding = arr.slice(0, remainingItems);
        lastChunk.push(...padding);
    }
    
    return chunks;
};
