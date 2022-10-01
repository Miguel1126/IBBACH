export const formatTime = (time) => {
    let twelveHours = {
        13: "01",
        14: "02",
        15: "03",
        16: "04",
        17: "05",
        18: "06",
        19: "07",
        20: "08",
        21: "09",
        22: "10",
        23: "11"
    }
    let timeSplit = time.split(":")
    let amOrPm = timeSplit[0] > 12 ? "PM" : "AM"
    let hour = timeSplit[0] > 12 ? twelveHours[timeSplit[0]] : timeSplit[0]

    return `${hour}:${timeSplit[1]} ${amOrPm}`
}