//#region Public methods
export const mapKeyToDisplayName = (data, key) => {
  return data.find((x) => x.id === key)?.title;
};
//#endregion

//#region Private methods
//#endregion
