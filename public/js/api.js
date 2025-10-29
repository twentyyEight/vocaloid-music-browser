export async function getAlbumById(id) {

    const res = await fetch(`/api/album/${id}`)
    if (!res.ok) throw new Error
    return res.json()
}

export async function getSongById(id) {

    try {
        const res = await fetch(`/api/song/${id}`)
        return res.json()

    } catch (error) {
        console.error(error)
    }
}
