export const formatTime = (time) => {
    let timeSplit = time.split(":")
    let amOrPm = timeSplit[0] > 12 ? "PM" : "AM"
    let hour = timeSplit[0] > 12 ? timeSplit[0] - 12 : timeSplit[0]

    return `${hour}:${timeSplit[1]} ${amOrPm}`
}

export const formatDate = (date) => {
    
    let dateSplit = date.split("-")
    let daySeparatedFromTime = dateSplit[2].split("T")
    let timeSeparatedFromDay = formatTime( daySeparatedFromTime[1] )  

    return `${daySeparatedFromTime[0]}/${dateSplit[1]}/${dateSplit[0]} - ${timeSeparatedFromDay}`
}