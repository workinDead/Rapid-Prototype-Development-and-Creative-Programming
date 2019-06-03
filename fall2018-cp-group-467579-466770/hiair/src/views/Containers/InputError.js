import React from 'react';
export const InputError = ({inputError}) =>
  <div className='inputError'>
    {Object.keys(inputError).map((field, i) => {
      if(inputError[field].length > 0){
        return (
          <p key={i}>{field} {inputError[field]}</p >
        )        
      } else {
        return '';
      }
    })}
  </div>