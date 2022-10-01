export const formatTime = (time) => {
    let timeSplit = time.split(":")
    let amOrPm = timeSplit[0] > 12 ? "PM" : "AM"
    let hour = timeSplit[0] > 12 ? timeSplit[0] - 12 : timeSplit[0]

    return `${hour}:${timeSplit[1]} ${amOrPm}`
}